<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Exceptions;

use DomainException;

class ProductNotFound extends DomainException
{
    public static function withId(string $id): self {
        return new self("Product with id {$id} not found");
    }
}