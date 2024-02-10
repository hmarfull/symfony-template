<?php

declare(strict_types=1);

namespace App\Shared\Domain\Utils;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;

final class TimestampUtils
{
    const MILLISECONDS_IN_A_SECOND = 1000;
    const ISO8601_WITH_MICROSECONDS_FORMAT = 'Y-m-d\TH:i:s.uO';

    public static function fromTimestampWithMillis(int $unixTimestampWithMillis): DateTimeImmutable
    {
        $asSeconds = (int) floor($unixTimestampWithMillis / self::MILLISECONDS_IN_A_SECOND);

        $dateTime = new DateTime('@'.((string) $asSeconds));
        $dateTime = $dateTime->setTimezone(new DateTimeZone('UTC'));

        return new DateTimeImmutable(
            $dateTime->format('Y-m-d\TH:i:s').'.'.
            sprintf('%03d', $unixTimestampWithMillis % self::MILLISECONDS_IN_A_SECOND).'000'.
            $dateTime->format('O')
        );
    }

    public static function toMillisecondsTimestamp(DateTimeImmutable $dateTime): int
    {
        $timestamp = $dateTime->getTimestamp();
        $microseconds = (float) ((string) $timestamp.'.'.(string) $dateTime->format('u'));

        return (int) ($microseconds * self::MILLISECONDS_IN_A_SECOND);
    }

    public static function getNowMicroTime(): DateTimeImmutable
    {
        return self::fromTimestampWithMillis((int) round(microtime(true) * self::MILLISECONDS_IN_A_SECOND));
    }

    public static function getNowMillis(): int
    {
        return self::toMillisecondsTimestamp(self::getNowMicroTime());
    }
}