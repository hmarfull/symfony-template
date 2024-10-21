<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Repositories;

use App\Discounts\Domain\Product;

interface ProductRepository
{
    public function getById(string $id): Product;
}