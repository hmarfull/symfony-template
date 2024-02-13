<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Infrastructure\Partners;

use App\Hotels\Booking\Infrastructure\Partners\PmsBookingCollector;
use App\Tests\Shared\Domain\StubCreator;
use App\Tests\Shared\PhpUnit\UnitTestCase;
use DateTimeImmutable;

final class PmsBookingCollectorTest extends UnitTestCase
{
    private PmsBookingCollector $collector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->collector = new PmsBookingCollector();
    }

    /** @test */
    public function collectBookings(): void
    {
        $since = DateTimeImmutable::createFromMutable(StubCreator::random()->dateTimeBetween('-2 days'));

        $bookings = $this->collector->collect($since);

        self::assertNotNull($bookings);
    }
}