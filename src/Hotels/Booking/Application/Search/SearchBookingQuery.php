<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Search;

use App\Shared\Domain\Bus\Query\Query;

final class SearchBookingQuery implements Query
{
    public function __construct(private string $hotelId, private string $roomId)
    {
    }

    public function hotelId(): string
    {
        return $this->hotelId;
    }

    public function roomId(): string
    {
        return $this->roomId;
    }
}