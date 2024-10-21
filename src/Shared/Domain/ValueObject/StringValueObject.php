<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    public function __construct(protected string $value)
    {
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(StringValueObject $object): bool
    {
        return $this->value === $object->value();
    }
}