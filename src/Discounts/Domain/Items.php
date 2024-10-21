<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;

class Items
{
    private array $items;

    public function __construct(Item ...$items)
    {
        $this->items = $items;
    }

    public static function fromArray(array $itemsData): self
    {
        $items = map(function (array $itemData) {
            return Item::fromArray($itemData);
        }, $itemsData);

        return new self(...$items);
    }

    public function add(Item $item): void
    {
        $this->items[] = $item;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function first(): ?Item
    {
        return $this->items[0] ?? null;
    }

    public function getItemsWithQuantityOverAThreshold(int $threshold): array
    {
        return filter(function (Item $item) use ($threshold){
            if ($threshold <= $item->quantity()) {
                return $item;
            }
            return null;
        }, $this->items);
    }
}