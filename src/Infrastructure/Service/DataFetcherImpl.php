<?php

namespace BetterMe\TestAssigment\Infrastructure\Service;

use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponse;
use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponseWithFallback;
use BetterMe\TestAssigment\Infrastructure\Interface\DataFetcher;
use BetterMe\TestAssigment\Infrastructure\Interface\ExternalRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @phpstan-type DataFetcherResponse array{request: ExternalRequest, response: null|ResponseInterface}
 */
readonly class DataFetcherImpl implements DataFetcher
{
    private Serializer $serializer;

    public function __construct(private HttpClientInterface $httpClient, private LoggerInterface $logger)
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    public function fetch(array $mapping, string $resultClassName): object
    {
        $requests = $this->getRequests($mapping);

        $httpResponses = $this->getHttpResponses($requests);

        $objectsResponses = $this->getObjectsResponses($httpResponses);

        return $this->makeResult($mapping, $objectsResponses, $resultClassName);
    }

    /**
     * @return list<ExternalRequest>
     */
    private function getRequests(array $mapping): array
    {
        $requests = [];

        foreach ($mapping as $valueMapping) {
            if ($valueMapping instanceof ValueFromResponse) {
                $requests[spl_object_id($valueMapping->request)] = $valueMapping->request;
            }

            if ($valueMapping instanceof ValueFromResponseWithFallback) {
                $requestsByKey = array_map(
                    fn(ValueFromResponse $fetchFieldFromSource) => $fetchFieldFromSource->request,
                    $valueMapping->values,
                );
                foreach ($requestsByKey as $request) {
                    $requests[spl_object_id($request)] = $request;
                }
            }
        }

        return $requests;
    }

    /**
     * @param list<ExternalRequest> $requests
     * @return array<string, DataFetcherResponse]
     */
    protected function getHttpResponses(array $requests): array
    {
        $httpClientResponses = [];
        foreach ($requests as $request) {
            try {
                $httpClientResponses[spl_object_id($request)] = [
                    'request' => $request,
                    'response' => $this->httpClient->request(
                        Request::METHOD_GET,
                        $request->getUri(),
                    ),
                ];
            } catch (ExceptionInterface $e) {
                $this->logger->error($e->getMessage());
                $httpClientResponses[spl_object_id($request)] = [
                    'request' => $request,
                    'response' => null,
                ];
            }
        }
        return $httpClientResponses;
    }

    protected function getObjectsResponses(array $httpResponses): array
    {
        $objectsResponses = [];
        /**
         * @var DataFetcherResponse $httpResponse
         */
        foreach ($httpResponses as $requestId => $httpResponse) {
            try {
                if ($httpResponse['response']) {
                    $rawHttpResponseBody = $httpResponse['response']->getContent();
                    $objectsResponses[$requestId] = $this->serializer->deserialize(
                        $rawHttpResponseBody,
                        $httpResponse['request']->getResponseClass(),
                        JsonEncoder::FORMAT
                    );
                }   else {
                    $objectsResponses[$requestId] = null;
                }
            } catch (ExceptionInterface $e) {
                $this->logger->error($e->getMessage());
                $objectsResponses[$requestId] = null;
            }
        }
        return $objectsResponses;
    }

    protected function makeResult(array $mapping, array $responses, string $resultClassName): object
    {
        $result = [];

        foreach ($mapping as $key => $valueMapping) {
            if ($valueMapping instanceof ValueFromResponse) {
                $response = $responses[spl_object_id($valueMapping->request)];
                if ($response) {
                    $result[$key] = call_user_func($valueMapping->getFromResponseFn, $response);
                } else {
                    $result[$key] = null;
                }
            }   elseif ($valueMapping instanceof ValueFromResponseWithFallback) {
                foreach ($valueMapping->values as $fallbackValueMapping) {
                    $response = $responses[spl_object_id($fallbackValueMapping->request)];
                    if ($response) {
                        $result[$key] = call_user_func($fallbackValueMapping->getFromResponseFn, $response);
                        break;
                    }
                }

                if (!array_key_exists($key, $result)) {
                    $result[$key] = null;
                }
            }   else {
                $result[$key] = $valueMapping;
            }
        }

        return $this->serializer->denormalize($result, $resultClassName);
    }
}
