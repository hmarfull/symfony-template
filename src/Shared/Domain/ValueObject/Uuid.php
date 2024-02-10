<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

abstract class Uuid implements Stringable
{
    final public function __construct(protected string $value)
    {
        $this->guard($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    final public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $valueToCompare): bool
    {
        return $this->value() === $valueToCompare->value();
    }

    private function guard(string $uuid): void
    {
        if (!RamseyUuid::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $uuid));
        }
    }
}