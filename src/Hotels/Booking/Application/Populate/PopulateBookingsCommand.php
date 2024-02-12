<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Populate;

use App\Shared\Domain\Bus\Command\Command;
use DateTimeImmutable;

final class PopulateBookingsCommand implements Command
{
    public function __construct(private DateTimeImmutable $since)
    {
    }

    public function since(): DateTimeImmutable
    {
        return $this->since;
    }
}