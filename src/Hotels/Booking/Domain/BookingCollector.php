<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

use DateTimeImmutable;

interface BookingCollector
{
    public function collect(DateTimeImmutable $since): Bookings;
}