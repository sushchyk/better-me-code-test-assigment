<?php

namespace BetterMe\TestAssigment\Infrastructure\Dto;

readonly class ValueFromResponseWithFallback
{
    /**
     * @param list<ValueFromResponse> $values
     */
    public function __construct(public array $values)
    {
    }
}
