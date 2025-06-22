<?php

namespace BetterMe\TestAssigment\App\Query;

use BetterMe\TestAssigment\Domain\ValueObject\Uuid;

readonly class GetProfileQuery
{
    public function __construct(public Uuid $id)
    {

    }
}
