<?php

namespace BetterMe\TestAssigment\Infrastructure\Interface;

use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponse;
use BetterMe\TestAssigment\Infrastructure\Dto\ValueFromResponseWithFallback;

interface DataFetcher
{
    /**
     * @template T
     * @param list<string, ValueFromResponse|ValueFromResponseWithFallback> $config
     * @param class-string<T> $resultClassName
     * @return T
     */
    public function fetch(array $config, string $resultClassName): object;
}
