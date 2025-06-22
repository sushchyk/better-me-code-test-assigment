<?php

namespace BetterMe\TestAssigment\App\QueryHandler;

use BetterMe\TestAssigment\App\Dto\ProfileDto;
use BetterMe\TestAssigment\App\ExternalRequest\Source1Request;
use BetterMe\TestAssigment\App\ExternalRequest\Source2Request;
use BetterMe\TestAssigment\App\ExternalRequest\Source3Request;
use BetterMe\TestAssigment\App\ExternalRequest\Source4Request;
use BetterMe\TestAssigment\App\ExternalResponse\Source1Response;
use BetterMe\TestAssigment\App\ExternalResponse\Source2Response;
use BetterMe\TestAssigment\App\ExternalResponse\Source3Response;
use BetterMe\TestAssigment\App\ExternalResponse\Source4Response;
use BetterMe\TestAssigment\App\Query\GetProfileQuery;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;
use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponse;
use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponseWithFallback;
use BetterMe\TestAssigment\Infrastructure\Interface\DataFetcher;


readonly class GetProfileQueryHandler
{
    public function __construct(private DataFetcher $dataFetcher)
    {

    }

    public function handle(GetProfileQuery $query): ProfileDto
    {
        $source1Request = new Source1Request($query->id);
        $source2Request = new Source2Request($query->id);
        $source3Request = new Source3Request($query->id);
        $source4Request = new Source4Request($query->id);

        $profileDto = $this->dataFetcher->fetch([
            'email' => new ValueFromResponse($source1Request, fn(Source1Response $resp) => $resp->email),
            'name' => new ValueFromResponseWithFallback([
                new ValueFromResponse($source2Request, fn(Source2Response $resp) => $resp->name),
                new ValueFromResponse($source3Request, fn(Source3Response $resp) => $resp->name),
                new ValueFromResponse($source1Request, fn(Source1Response $resp) => $resp->name),
            ]),
            'avatarUrl' => new ValueFromResponse($source3Request, fn(Source3Response $resp) => $resp->avatar_url),
            'unknown' => new ValueFromResponse($source4Request, fn(Source4Response $resp) => $resp->unknown),
        ], ProfileDto::class);

        $profileDto->id = $query->id;

        return $profileDto;
    }
}
