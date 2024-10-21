<?php

declare(strict_types=1);

namespace App\Discounts\Application;

use App\Discounts\Domain\DiscountApplicator;
use App\Discounts\Domain\Order;
use App\Shared\Domain\Bus\Query\QueryHandler;

readonly class CalculateOrderDiscountQueryHandler implements QueryHandler
{
    public function __construct(private DiscountApplicator $discountApplicator)
    {
    }

    public function __invoke(CalculateOrderDiscountQuery $query): DiscountResponse
    {
        $order = Order::fromArray($query->orderData());

        ($this->discountApplicator)($order);

        return new DiscountResponse($order->totalDiscount());
    }
}