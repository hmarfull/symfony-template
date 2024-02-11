<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

final readonly class BookingSearcher
{
    public function __construct(private BookingRepository $repository)
    {
    }

    public function __invoke(HotelId $hotelId, RoomId $roomId): ?Booking
    {
        return $this->repository->search($hotelId, $roomId);
    }
}