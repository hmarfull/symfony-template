<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Search;

use App\Hotels\Booking\Domain\Booking;

final class BookingResponseConverter
{
    private const string DATE_FORMAT = "Y-m-d";
    public function __invoke(Booking $booking): BookingResponse
    {
        return new BookingResponse(
        $booking->id()->value(),
        $booking->hotelId()->value(),
        $booking->locator(),
        $booking->roomId()->value(),
        $booking->checkIn()->format(self::DATE_FORMAT),
        $booking->checkOut()->format(self::DATE_FORMAT),
        $booking->numberOfNights(),
        $booking->pax()->total(),
        $booking->guest()->toPlain(),
        );
    }
}