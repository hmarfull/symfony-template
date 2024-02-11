<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

final readonly class Pax
{
    public function __construct(
        private int $adults,
        private int $kids,
        private int $babies,
    )
    {
    }

    public function total(): int
    {
        return $this->adults + $this->kids + $this->babies;
    }
}