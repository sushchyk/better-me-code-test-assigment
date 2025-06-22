<?php

namespace BetterMe\TestAssigment\App\Dto;

use BetterMe\TestAssigment\Domain\ValueObject\Uuid;

class ProfileDto
{
    public Uuid $id;
    public null|string $email;
    public null|string $name;
    public null|string $avatarUrl;
    public null|string $unknown;
}
