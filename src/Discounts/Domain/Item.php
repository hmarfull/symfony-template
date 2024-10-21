<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use function Lambdish\Phunctional\get;

class Item
{
    public function __construct(
        private readonly string $productId,
        private int             $quantity,
        private readonly float  $unitPrice,
        private readonly float  $total
    )
    {
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unitPrice(): float
    {
        return $this->unitPrice;
    }

    public function total(): float
    {
        return $this->total;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            get('product-id', $data),
            (int)get('quantity', $data),
            (float)get('unit-price', $data),
            (float)get('total', $data),
        );
    }
// TODO
//    public function addFreeUnits(int $amount): void
//    {
//        $this->quantity += $amount;
//    }
}