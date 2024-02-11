<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Infrastructure\PhpUnit;

use App\Hotels\Booking\Domain\Booking;
use App\Hotels\Booking\Domain\BookingRepository;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use App\Tests\Hotels\Booking\Domain\TestUtils;
use App\Tests\Shared\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class BookingUnitTestCase extends UnitTestCase
{
    private BookingRepository|MockInterface|null $repository;

    public function repository(): BookingRepository|MockInterface
    {
        return $this->repository ??= $this->mock(BookingRepository::class);
    }

    public function shouldSearchBookingByHotelAndRoomAndReturnBooking(Booking $booking): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->with(TestUtils::similarTo($booking->hotelId()), TestUtils::similarTo($booking->roomId()))
            ->andReturn($booking);
    }

    public function shouldSearchBookingByHotelAndRoomAndReturnNull(HotelId $hotelId, RoomId $roomId): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->with(TestUtils::similarTo($hotelId), TestUtils::similarTo($roomId))
            ->andReturnNull();
    }
}