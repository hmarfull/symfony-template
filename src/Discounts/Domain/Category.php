<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use App\Shared\Domain\ValueObject\IntegerValueObject;

class Category extends IntegerValueObject
{
    public const int TOOLS = 1;
    public const int SWITCHES = 2;

    public function isTool(): bool
    {
        return $this->value === self::TOOLS;
    }

    public function isSwitch(): bool
    {
        return $this->value === self::SWITCHES;
    }
}