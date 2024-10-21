<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

class Product
{
    public function __construct(private string $id, private readonly Category $category)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function category(): Category
    {
        return $this->category;
    }
}