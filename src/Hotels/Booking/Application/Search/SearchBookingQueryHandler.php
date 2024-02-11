<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Search;

use App\Hotels\Booking\Domain\BookingSearcher;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use App\Shared\Domain\Bus\Query\QueryHandler;

final readonly class SearchBookingQueryHandler implements QueryHandler
{
    public function __construct(private BookingSearcher $searcher)
    {
    }

    public function __invoke(SearchBookingQuery $query): ?BookingResponse
    {
        $hotelId = new HotelId($query->hotelId());
        $roomId = new RoomId($query->roomId());

        $booking = ($this->searcher)($hotelId, $roomId);

        return $booking !== null ? (new BookingResponseConverter)($booking) : null;
    }
}