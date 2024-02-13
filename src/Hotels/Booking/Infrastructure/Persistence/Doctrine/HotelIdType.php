<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Persistence\Doctrine;

use App\Hotels\Booking\Domain\HotelId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class HotelIdType extends StringType
{
    public const string NAME = 'hotel_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): HotelId
    {
        return new HotelId($value);
    }

    /**
     * @param HotelId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }
}