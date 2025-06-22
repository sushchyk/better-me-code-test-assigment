<?php

namespace BetterMe\TestAssigment\App\ExternalRequest;

use BetterMe\TestAssigment\App\ExternalResponse\Source1Response;
use BetterMe\TestAssigment\App\ExternalResponse\Source3Response;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;
use BetterMe\TestAssigment\Infrastructure\Interface\ExternalRequest;

readonly class Source3Request implements ExternalRequest
{
    public function __construct(private Uuid $profileId)
    {

    }

    public function getUri(): string
    {
        return '/mock-api/source3?id=' . $this->profileId;
    }

    public function getResponseClass(): string
    {
        return Source3Response::class;
    }
}
