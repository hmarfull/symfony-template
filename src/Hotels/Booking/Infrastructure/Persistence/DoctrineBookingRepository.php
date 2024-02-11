<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Persistence;

use App\Hotels\Booking\Domain\Booking;
use App\Hotels\Booking\Domain\BookingRepository;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineBookingRepository extends DoctrineRepository implements BookingRepository
{
    public function search(HotelId $hotelId, RoomId $roomId): ?Booking
    {
        // TODO: Implement search() method.
    }
}