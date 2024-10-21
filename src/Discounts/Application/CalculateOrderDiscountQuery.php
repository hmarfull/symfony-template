<?php

declare(strict_types=1);

namespace App\Discounts\Application;

use App\Shared\Domain\Bus\Query\Query;

readonly class CalculateOrderDiscountQuery implements Query
{
    public function __construct(private array $orderData)
    {
    }

    public function orderData(): array
    {
        return $this->orderData;
    }
}