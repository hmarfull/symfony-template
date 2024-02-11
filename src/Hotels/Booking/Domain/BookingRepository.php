<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

interface BookingRepository
{
    public function search(HotelId $hotelId, RoomId $roomId): ?Booking;
}