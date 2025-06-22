<?php

namespace BetterMe\TestAssigment\App\Dto;

class ProfileDto
{
    public function __construct(
        public null|string $email,
        public null|string $name,
        public null|string $avatarUrl,
        public null|string $unknown,
    ) {

    }

}
