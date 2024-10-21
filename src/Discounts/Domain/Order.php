<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use function Lambdish\Phunctional\get;

class Order extends AggregateRoot
{
    private float $totalDiscount = 0.0;
    public function __construct(
        private readonly string $id,
        private readonly string $customerId,
        private readonly Items  $items,
        private readonly float $total
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function customerId(): string
    {
        return $this->customerId;
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function total(): float
    {
        return $this->total;
    }
    public function totalDiscount(): float
    {
        return $this->totalDiscount;
    }

    public function addDiscount(float $discount): void
    {
        $this->totalDiscount += $discount;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            get('id', $data),
            get('customer-id', $data),
            Items::fromArray(get('items', $data, [])),
            (float) get('total', $data)
        );
    }
}