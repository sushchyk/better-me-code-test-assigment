<?php

namespace BetterMe\TestAssigment\Tests\Functional\Http;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetProfileActionTest extends WebTestCase
{
    public function testItReturnsCorrectProfileWhenAllExternalResponsesAreSuccessful(): void
    {
        $client = static::createClient();
        self::getContainer()->set(HttpClientInterface::class, new MockHttpClient([
                new JsonMockResponse([
                    'email' => $email = 'test@test.com',
                    'name' => 'Bar Dor',
                ]),
                new JsonMockResponse([
                    'name' => $name = 'John Foo',
                ]),
                new JsonMockResponse([
                    'name'  => 'John Bar',
                    'avatar_url' => $avatarUrl = 'https://i.pravatar.cc/300',
                ]),
                new JsonMockResponse([
                    'unknown' => $unknown = 'alien'
                ]),
            ])
        );
        $client->request('GET', '/api/profile/' . $id = '01978f65-0286-7ebd-90dd-12d37c8f9444');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode(),
        );
        $this->assertEquals(
            [
                'id' => $id,
                'email' => $email,
                'name' => $name,
                'avatar_url' => $avatarUrl,
                'unknown' => $unknown,
            ],
            json_decode($client->getResponse()->getContent(), true),
        );
    }

    public function testItReturnsCorrectProfileWhenSource2ReturnsHttpError()
    {
        $client = static::createClient();
        self::getContainer()->set(HttpClientInterface::class, new MockHttpClient([
                new JsonMockResponse([
                    'email' => $email = 'test@test.com',
                    'name' => 'Bar Dor',
                ]),
                new JsonMockResponse([
                    'error' => 'Some error',
                ], ['http_code' => 500]),
                new JsonMockResponse([
                    'name'  => $name = 'John Bar',
                    'avatar_url' => $avatarUrl = 'https://i.pravatar.cc/300',
                ]),
                new JsonMockResponse([
                    'unknown' => $unknown = 'alien'
                ]),
            ])
        );
        $client->request('GET', '/api/profile/' . $id = '01978f65-0286-7ebd-90dd-12d37c8f9444');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode(),
        );
        $this->assertEquals(
            [
                'id' => $id,
                'email' => $email,
                'name' => $name,
                'avatar_url' => $avatarUrl,
                'unknown' => $unknown,
            ],
            json_decode($client->getResponse()->getContent(), true),
        );
    }
}
