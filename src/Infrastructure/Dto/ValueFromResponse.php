<?php

namespace BetterMe\TestAssigment\Infrastructure\Dto;

use BetterMe\TestAssigment\Infrastructure\Interface\ExternalRequest;

readonly class ValueFromResponse
{
    public function __construct(public ExternalRequest $request, public \Closure $getFromResponseFn)
    {

    }
}
