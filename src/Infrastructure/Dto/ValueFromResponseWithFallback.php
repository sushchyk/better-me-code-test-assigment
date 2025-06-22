<?php

namespace BetterMe\TestAssigment\Infrastructure\Dto;

readonly class ValueFromResponseWithFallback
{
    /**
     * @param ValueFromResponse[] $values
     */
    public function __construct(public array $values)
    {
    }
}
