<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Domain;

use App\Hotels\Booking\Domain\HotelId;
use App\Tests\Shared\Domain\StubCreator;

final class HotelIdStub
{
    public static function create(?string $value = null): HotelId
    {
        return new HotelId($value ?? StubCreator::random()->uuid());
    }
}