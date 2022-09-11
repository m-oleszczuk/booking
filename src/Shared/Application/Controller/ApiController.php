<?php

declare(strict_types=1);

namespace App\Shared\Application\Controller;

use App\Shared\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class ApiController extends AbstractController
{
    protected MessageBusInterface $commandBus;
    protected QueryBus $queryBus;

    public function __construct(MessageBusInterface $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    protected function created(?array $data = null): JsonResponse
    {
        return new JsonResponse(['data' => $data], Response::HTTP_CREATED);
    }

    protected function updated(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

    protected function deleted(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    protected function notFound(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NOT_FOUND);
    }

    protected function notModified(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NOT_MODIFIED);
    }
}
