<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Tests\Shared\Infrastructure\Mockery\MatcherIsSimilar;
use App\Tests\Shared\PhpUnit\ConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar(mixed $expected, mixed $actual): bool
    {
        $constraint = new ConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function similarTo(mixed $value, float $delta = 0.0): MatcherIsSimilar
    {
        return new MatcherIsSimilar($value, $delta);
    }

}