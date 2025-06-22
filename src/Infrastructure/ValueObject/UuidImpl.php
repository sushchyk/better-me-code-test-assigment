<?php

namespace BetterMe\TestAssigment\Infrastructure\ValueObject;

use BetterMe\TestAssigment\Domain\Exception\DomainException;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;
use Symfony\Component\Uid\UuidV7;

readonly class UuidImpl implements Uuid
{
    private function __construct(private UuidV7 $uuid)
    {

    }

    public static function fromString(string $uuid): self
    {
        try {
            return new self(new UuidV7($uuid));
        }   catch (\InvalidArgumentException $e) {
            throw new DomainException($e->getMessage());
        }
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
