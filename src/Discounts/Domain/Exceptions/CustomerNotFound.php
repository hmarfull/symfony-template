<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Exceptions;

use DomainException;

class CustomerNotFound extends DomainException
{
    public static function withId(string $id): self {
        return new self("Customer with id {$id} not found");
    }
}