<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class DateTimeImmutableMicrosecondsType extends Type
{
    public const  NAME = 'datetime_immutable_microseconds';
    private const DATE_TIME_FORMAT = 'Y-m-d H:i:s.u';

    public function getName(): string
    {
        return static::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'DATETIME(6)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        return null !== $value ? new DateTimeImmutable($value) : null;
    }

    /**
     * @var DateTimeImmutable $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->format(self::DATE_TIME_FORMAT);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
