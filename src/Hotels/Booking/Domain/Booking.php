<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use DateTimeImmutable;

final class Booking extends AggregateRoot
{
    public function __construct(
        private BookingId         $id,
        private HotelId           $hotelId,
        private RoomId            $roomId,
        private Guest             $guest,
        private string            $locator,
        private DateTimeImmutable $checkIn,
        private DateTimeImmutable $checkOut,
        private Pax               $pax,
        private DateTimeImmutable $created,
        private string            $signature,
    )
    {
    }

    public function id(): BookingId
    {
        return $this->id;
    }

    public function hotelId(): HotelId
    {
        return $this->hotelId;
    }

    public function roomId(): RoomId
    {
        return $this->roomId;
    }

    public function guest(): Guest
    {
        return $this->guest;
    }

    public function locator(): string
    {
        return $this->locator;
    }

    public function checkIn(): DateTimeImmutable
    {
        return $this->checkIn;
    }

    public function checkOut(): DateTimeImmutable
    {
        return $this->checkOut;
    }

    public function pax(): Pax
    {
        return $this->pax;
    }

    public function created(): DateTimeImmutable
    {
        return $this->created;
    }

    public function signature(): string
    {
        return $this->signature;
    }

    public function numberOfNights(): int
    {
        return intval($this->checkIn->diff($this->checkOut)->format("%a"));
    }

}