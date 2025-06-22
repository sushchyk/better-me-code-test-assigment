<?php

namespace BetterMe\TestAssigment\App\ExternalResponse;

readonly class Source3Response
{
    public function __construct(
        public string $name,
        public string $avatar_url,
    ) {

    }
}
