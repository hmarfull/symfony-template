<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use function Lambdish\Phunctional\filter;

class Products
{
    private array $products;

    public function __construct(Product ...$products)
    {
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function all(): array
    {
        return $this->products;
    }

    public function get(string $productId): Product
    {
        return filter(function (Product $product) use ($productId) {
            return $product->id() === $productId ? $product : null;
        }, $this->products)[0];
    }
}