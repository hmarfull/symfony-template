<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Controller;

use App\Discounts\Application\CalculateOrderDiscountQuery;
use App\Discounts\Application\DiscountResponse;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Symfony\ApiController;
use App\Shared\Infrastructure\Symfony\ApiExceptionsHttpStatusCodeMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetOrderDiscountController extends ApiController
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

    public function __invoke(Request $request): JsonResponse
    {
        $orderData = $this->parseJsonContent($request->getContent());
        /** @var DiscountResponse $response */
        $response = $this->ask(new CalculateOrderDiscountQuery($orderData));

        return new JsonResponse(['discount' => (string) $response->discount()], Response::HTTP_OK);
    }

    private function parseJsonContent(string $getContent): array
    {
        return json_decode($getContent, true);
    }
}