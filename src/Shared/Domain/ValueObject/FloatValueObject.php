<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    public function __construct(protected float $value)
    {
    }

    final public function value(): float
    {
        return $this->value;
    }

    final public function equals(FloatValueObject $object): bool
    {
        return $this->value === $object->value();
    }
}