<?php

declare(strict_types=1);

namespace App\Hotels\Booking\UI\Controller;

use App\Hotels\Booking\Application\Search\SearchBookingQuery;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Symfony\ApiController;
use App\Shared\Infrastructure\Symfony\ApiExceptionsHttpStatusCodeMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetBookingController extends ApiController
{
    protected function exceptions(): array
    {
        return [];
    }

    public function __construct(
        QueryBus                           $queryBus,
        CommandBus                         $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    )
    {
        parent::__construct($queryBus, $commandBus, $exceptionHandler);
    }

    public function __invoke(string $hotelId, string $roomId, Request $request): JsonResponse
    {
        $booking = $this->ask(new SearchBookingQuery($hotelId, $roomId));

        return new JsonResponse($booking?->toPlain(), Response::HTTP_OK);
    }
}