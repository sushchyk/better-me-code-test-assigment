<?php

namespace BetterMe\TestAssigment\Domain\ValueObject;

use BetterMe\TestAssigment\Domain\Exception\DomainException;

interface Uuid
{
    /**
     * @throws DomainException
     */
    public static function fromString(string $uuid): self;

    public function __toString(): string;
}
