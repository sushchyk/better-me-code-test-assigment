<?php

namespace BetterMe\TestAssigment\Infrastructure\Interface;

use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponse;
use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponseWithFallback;

interface DataFetcher
{
    /**
     * @template T
     * @param array<string, ValueFromResponse|ValueFromResponseWithFallback> $mapping
     * @param class-string<T> $resultClassName
     * @return T
     */
    public function fetch(array $mapping, string $resultClassName): object;
}
