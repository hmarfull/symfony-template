<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Application;

use App\Hotels\Booking\Application\Search\SearchBookingQuery;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use App\Tests\Hotels\Booking\Domain\HotelIdStub;
use App\Tests\Hotels\Booking\Domain\RoomIdStub;

final class SearchBookingQueryStub
{
    public static function create(?HotelId $hotelId = null, ?RoomId $roomId = null): SearchBookingQuery
    {
        return new SearchBookingQuery(
            $hotelId?->value() ?? HotelIdStub::create()->value(),
            $roomId?->value() ?? RoomIdStub::create()->value(),
        );
    }
}