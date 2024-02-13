<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Persistence\Doctrine;

use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\RoomId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class RoomIdType extends StringType
{
    public const string NAME = 'room_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): RoomId
    {
        return new RoomId($value);
    }

    /**
     * @param RoomId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }
}