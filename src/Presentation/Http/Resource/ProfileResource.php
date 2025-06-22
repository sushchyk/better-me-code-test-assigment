<?php

namespace BetterMe\TestAssigment\Presentation\Http\Resource;

use BetterMe\TestAssigment\App\Dto\ProfileDto;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;

readonly class ProfileResource
{
    public function __construct(
        private Uuid $id,
        private ProfileDto $dto
    ) {

    }

    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'email' => $this->dto->email,
            'name' => $this->dto->name,
            'avatar_url' => $this->dto->avatarUrl,
            'unknown' => $this->dto->unknown,
        ];
    }
}
