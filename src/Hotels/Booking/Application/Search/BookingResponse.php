<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Search;

use App\Shared\Domain\Bus\Query\Response;

final readonly class BookingResponse implements Response
{
    public function __construct(
        private string $bookingId,
        private string $hotelId,
        private string $locator,
        private string $roomId,
        private string $checkIn,
        private string $checkOut,
        private int    $numberOfNights,
        private int    $totalPax,
        private array  $guest,
    )
    {
    }

    public function toPlain(): array
    {
        return [
            "bookingId" => $this->bookingId,
            "hotel" => $this->hotelId,
            "locator" => $this->locator,
            "room" => $this->roomId,
            "checkIn" => $this->checkIn,
            "checkOut" => $this->checkOut,
            "numberOfNights" => $this->numberOfNights,
            "totalPax" => $this->totalPax,
            "guests" => [$this->guest],
        ];
    }
}