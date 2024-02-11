<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Domain;

use App\Hotels\Booking\Domain\Booking;
use App\Hotels\Booking\Domain\BookingId;
use App\Hotels\Booking\Domain\Guest;
use App\Hotels\Booking\Domain\Pax;
use App\Tests\Shared\Domain\StubCreator;
use DateInterval;
use DateTimeImmutable;

final class BookingStub
{
    public static function create(): Booking
    {
        $checkIn = DateTimeImmutable::createFromMutable(StubCreator::random()->dateTimeThisDecade());

        return new Booking(
            new BookingId(StubCreator::random()->uuid()),
            HotelIdStub::create(),
            RoomIdStub::create(),
            new Guest(
                StubCreator::random()->name(),
                StubCreator::random()->lastName(),
                DateTimeImmutable::createFromMutable(StubCreator::random()->dateTimeThisCentury()),
                StubCreator::random()->text(20),
                StubCreator::random()->countryCode(),
            ),
            StubCreator::random()->text(10),
            $checkIn,
            $checkIn->add(DateInterval::createFromDateString(StubCreator::random()->numberBetween(1, 15) . ' days')),
            new Pax(
                StubCreator::random()->numberBetween(1, 2),
                StubCreator::random()->numberBetween(0, 3),
                StubCreator::random()->numberBetween(0, 1),
            ),
            $checkIn,
            StubCreator::random()->sha256(),
        );
    }
}