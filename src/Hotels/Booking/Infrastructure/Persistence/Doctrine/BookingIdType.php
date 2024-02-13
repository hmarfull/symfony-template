<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Persistence\Doctrine;

use App\Hotels\Booking\Domain\BookingId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class BookingIdType extends StringType
{
    public const string NAME = 'booking_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BookingId
    {
        return new BookingId($value);
    }

    /**
     * @param BookingId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }
}