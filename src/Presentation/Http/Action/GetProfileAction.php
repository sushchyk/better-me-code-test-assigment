<?php

namespace BetterMe\TestAssigment\Presentation\Http\Action;

use BetterMe\TestAssigment\App\Query\GetProfileQuery;
use BetterMe\TestAssigment\App\QueryHandler\GetProfileQueryHandler;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;
use BetterMe\TestAssigment\Presentation\Http\Resource\ProfileResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

readonly class GetProfileAction
{
    public function __construct(private GetProfileQueryHandler $queryHandler)
    {

    }

    #[Route('/api/profile/{id}', format: 'json')]
    public function __invoke(Uuid $id): JsonResponse
    {
        $profileDto = $this->queryHandler->handle(new GetProfileQuery($id));

        $profileResource = new ProfileResource($profileDto);

        return new JsonResponse($profileResource->toArray());
    }
}
