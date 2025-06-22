<?php

namespace BetterMe\TestAssigment\MockApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mock-api/source1', methods: ['GET'])]
readonly class Source1Action
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'email' => 'test@test.com',
            'name' => 'Bar Dor',
        ]);
    }
}
