<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Persistence;

use App\Hotels\Booking\Domain\Booking;
use App\Hotels\Booking\Domain\BookingRepository;
use App\Hotels\Booking\Domain\Bookings;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;


final class DoctrineBookingRepository extends DoctrineRepository implements BookingRepository
{
    const string ALIAS = 'b';

    public function search(HotelId $hotelId, RoomId $roomId): ?Booking
    {
        return $this->repository(Booking::class)->createQueryBuilder(self::ALIAS)
            ->andWhere(self::ALIAS . '.hotelId = :hotelId')
            ->andWhere(self::ALIAS . '.roomId = :roomId')
            ->andWhere(self::ALIAS . '.checkOut > :now')
            ->setParameter('hotelId', $hotelId->value())
            ->setParameter('roomId', $roomId->value())
            ->setParameter('now', new DateTimeImmutable(), Types::DATE_IMMUTABLE)
            ->orderBy(self::ALIAS . '.created', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function storeMultiple(Bookings $bookings): void
    {
        $this->persistMultiple(...$bookings->all());
    }
}