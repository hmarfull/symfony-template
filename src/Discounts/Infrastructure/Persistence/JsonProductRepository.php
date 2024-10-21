<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Persistence;

use App\Discounts\Domain\Category;
use App\Discounts\Domain\Exceptions\ProductNotFound;
use App\Discounts\Domain\Product;
use App\Discounts\Domain\Repositories\ProductRepository;
use function Lambdish\Phunctional\filter;

class JsonProductRepository implements ProductRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = json_decode('[
          {
            "id": "A101",
            "description": "Screwdriver",
            "category": "1",
            "price": "9.75"
          },
          {
            "id": "A102",
            "description": "Electric screwdriver",
            "category": "1",
            "price": "49.50"
          },
          {
            "id": "B101",
            "description": "Basic on-off switch",
            "category": "2",
            "price": "4.99"
          },
          {
            "id": "B102",
            "description": "Press button",
            "category": "2",
            "price": "4.99"
          },
          {
            "id": "B103",
            "description": "Switch with motion detector",
            "category": "2",
            "price": "12.95"
          }
        ]', true);
    }

    public function getById(string $id): Product
    {
        $product = filter(function (array $product) use ($id) {
            if ($product["id"] !== $id) {
                return null;
            }
            return $product;
        }, $this->products);

        $product = reset($product);

        if ([] === $product) {
            throw ProductNotFound::withId($id);
        }
        return new Product($product["id"], new Category((int) $product["category"]));
    }
}