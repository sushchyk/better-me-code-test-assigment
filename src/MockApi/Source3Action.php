<?php

namespace BetterMe\TestAssigment\MockApi;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mock-api/source3', methods: ['GET'])]
readonly class Source3Action
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'name'  => 'John Bar',
            'avatar_url' => 'https://i.pravatar.cc/300',
        ]);
    }
}
