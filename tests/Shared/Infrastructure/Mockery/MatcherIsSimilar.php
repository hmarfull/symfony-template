<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Mockery;

use App\Tests\Shared\PhpUnit\ConstraintIsSimilar;
use Mockery\Matcher\MatcherAbstract;
use Stringable;

final class MatcherIsSimilar extends MatcherAbstract implements Stringable
{
    private ConstraintIsSimilar $constraint;

    public function __construct(mixed $value, float $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new ConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual)
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}