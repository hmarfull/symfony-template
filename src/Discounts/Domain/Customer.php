<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

readonly class Customer
{
    public function __construct(private string $id, private float $revenue)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function revenue(): float
    {
        return $this->revenue;
    }
}