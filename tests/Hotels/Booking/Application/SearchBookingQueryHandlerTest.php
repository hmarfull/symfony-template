<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Application;

use App\Hotels\Booking\Application\Search\BookingResponseConverter;
use App\Hotels\Booking\Application\Search\SearchBookingQueryHandler;
use App\Hotels\Booking\Domain\BookingSearcher;
use App\Hotels\Booking\Infrastructure\Partners\PmsBookingCollector;
use App\Tests\Hotels\Booking\Domain\BookingStub;
use App\Tests\Hotels\Booking\Domain\HotelIdStub;
use App\Tests\Hotels\Booking\Domain\RoomIdStub;
use App\Tests\Hotels\Booking\Infrastructure\PhpUnit\BookingUnitTestCase;

final class SearchBookingQueryHandlerTest extends BookingUnitTestCase
{
    private SearchBookingQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new SearchBookingQueryHandler(new BookingSearcher($this->repository()));
    }

    /** @test */
    public function itShouldFindAnExistingBooking(): void
    {
        $booking = BookingStub::create();
        $query = SearchBookingQueryStub::create($booking->hotelId(), $booking->roomId());

        $this->shouldSearchBookingByHotelAndRoomAndReturnBooking($booking);

        $this->assertAskResponse(
            (new BookingResponseConverter())($booking),
            $query,
            $this->handler,
        );
    }

    /** @test */
    public function itShouldNotFindAnExistingBooking(): void
    {
        $hotelId = HotelIdStub::create();
        $roomId = RoomIdStub::create();
        $query = SearchBookingQueryStub::create($hotelId, $roomId);

        $this->shouldSearchBookingByHotelAndRoomAndReturnNull($hotelId, $roomId);

        $this->assertAskResponse(
            null,
            $query,
            $this->handler,
        );
    }
}