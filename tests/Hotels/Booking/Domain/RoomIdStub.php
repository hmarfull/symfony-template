<?php

declare(strict_types=1);

namespace App\Tests\Hotels\Booking\Domain;

use App\Hotels\Booking\Domain\RoomId;
use App\Tests\Shared\Domain\StubCreator;

final class RoomIdStub
{
    public static function create(?string $value = null): RoomId
    {
        return new RoomId($value ?? StubCreator::random()->buildingNumber());
    }
}