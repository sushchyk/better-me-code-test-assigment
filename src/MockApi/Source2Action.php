<?php

namespace BetterMe\TestAssigment\MockApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mock-api/source2', methods: ['GET'])]
readonly class Source2Action
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'name' => 'John Foo',
        ]);
    }
}
