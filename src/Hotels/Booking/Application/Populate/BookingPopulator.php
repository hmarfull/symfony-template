<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Populate;

use App\Hotels\Booking\Domain\BookingCollector;
use App\Hotels\Booking\Domain\BookingRepository;
use DateTimeImmutable;

final class BookingPopulator
{
    public function __construct(private BookingCollector $collector, private BookingRepository $repository)
    {
    }

    public function __invoke(DateTimeImmutable $since)
    {
        $bookings = $this->collector->collect($since);
        $this->repository->storeMultiple($bookings);
    }
}