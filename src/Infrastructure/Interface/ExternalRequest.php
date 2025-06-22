<?php

namespace BetterMe\TestAssigment\Infrastructure\Interface;

interface ExternalRequest
{
    public function getUri(): string;

    /**
     * @return class-string
     */
    public function getResponseClass(): string;
}
