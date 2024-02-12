<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

final class Bookings
{
    private array $bookings;

    public function __construct(Booking ...$booking)
    {
    }

    public function add(Booking $booking): void
    {
        $this->bookings[] = $booking;
    }

    public function all(): array
    {
        return $this->bookings;
    }
}