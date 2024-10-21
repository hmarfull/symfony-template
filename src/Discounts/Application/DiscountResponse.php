<?php

declare(strict_types=1);

namespace App\Discounts\Application;

use App\Shared\Domain\Bus\Query\Response;

readonly class DiscountResponse implements Response
{
    public function __construct(private float $discount)
    {
    }

    public function discount(): float
    {
        return $this->discount;
    }

}