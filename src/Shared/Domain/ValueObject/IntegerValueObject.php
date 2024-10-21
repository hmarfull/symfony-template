<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    public function __construct(protected int $value)
    {
    }

    final public function value(): int
    {
        return $this->value;
    }

    final public function equals(IntegerValueObject $object): bool
    {
        return $this->value === $object->value();
    }
}