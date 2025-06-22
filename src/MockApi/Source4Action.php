<?php

namespace BetterMe\TestAssigment\MockApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mock-api/source4', methods: ['GET'])]
readonly class Source4Action
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'unknown' => 'alien'
        ]);
    }
}
