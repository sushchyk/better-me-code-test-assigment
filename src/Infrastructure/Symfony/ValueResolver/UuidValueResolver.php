<?php

namespace BetterMe\TestAssigment\Infrastructure\Symfony\ValueResolver;

use BetterMe\TestAssigment\Domain\Exception\DomainException;
use BetterMe\TestAssigment\Domain\ValueObject\Uuid;
use BetterMe\TestAssigment\Infrastructure\ValueObject\UuidImpl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UuidValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!\is_string($value = $request->attributes->get($argument->getName()))
            || $argument->getType() !== Uuid::class
        ) {
            return [];
        }

        try {
            return [UuidImpl::fromString($value)];
        } catch (DomainException $e) {
            throw new NotFoundHttpException(\sprintf('The uid for the "%s" parameter is invalid.', $argument->getName()), $e);
        }
    }
}
