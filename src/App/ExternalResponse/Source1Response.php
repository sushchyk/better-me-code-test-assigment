<?php

namespace BetterMe\TestAssigment\App\ExternalResponse;

readonly class Source1Response
{
    public function __construct(
        public string $email,
        public string $name,
    ) {

    }
}
