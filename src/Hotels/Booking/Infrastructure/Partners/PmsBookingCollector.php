<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Infrastructure\Partners;

use App\Hotels\Booking\Domain\Booking;
use App\Hotels\Booking\Domain\BookingCollector;
use App\Hotels\Booking\Domain\BookingId;
use App\Hotels\Booking\Domain\Bookings;
use App\Hotels\Booking\Domain\Guest;
use App\Hotels\Booking\Domain\HotelId;
use App\Hotels\Booking\Domain\Pax;
use App\Hotels\Booking\Domain\RoomId;
use DateTimeImmutable;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\get;

final class PmsBookingCollector implements BookingCollector
{
    private const string PMS_URL = 'https://cluster-dev.stay-app.com/sta/pms-faker/stay/test/pms?ts=';
    private const array HOTEL_MAPPER = [
        "36001" => "70ce8358-600a-4bad-8ee6-acf46e1fb8db",
        "28001" => "3cbcd874-a7e0-4bb3-987e-eb36f05b7e7a",
        "28003" => "ca385c3b-c2b1-4691-b433-c8cd51883d25",
        "49001" => "5ab1d247-19ea-4850-9242-2d3ffbbdb58d",
    ];

    public function collect(DateTimeImmutable $since): Bookings
    {
        $items = $this->collectRawBookings($since);
        $bookings = new Bookings();

        each(function ($item) use (&$bookings) {
            $guest = get('guest', $item);
            $booking = get('booking', $item);
            $pax = get('pax', $booking);
            /** @var BookingId $bookingId */
            $bookingId = BookingId::random();
            $bookings->add(new Booking(
                $bookingId,
                new HotelId(self::HOTEL_MAPPER[get('hotel_id', $item)]),
                new RoomId(get('room', $booking)),
                new Guest(
                    get('name', $guest),
                    get('lastname', $guest),
                    DateTimeImmutable::createFromFormat('Y-m-d', get('birthdate', $guest)),
                    get('passport', $guest),
                    get('country', $guest),
                ),
                get('locator', $booking),
                DateTimeImmutable::createFromFormat('Y-m-d', get('check_in', $booking)),
                DateTimeImmutable::createFromFormat('Y-m-d', get('check_out', $booking)),
                new Pax(
                    (int) get('adults', $pax),
                    (int) get('kids', $pax),
                    (int) get('babies', $pax),
                ),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', get('created', $item)),
                get('signature', $item),
            ));
        }, $items);

        return $bookings;
    }

    public function collectRawBookings(DateTimeImmutable $since): array
    {
        $json = file_get_contents(self::PMS_URL . $since->getTimestamp());

        $response = json_decode($json, true);

        return get('bookings', $response);
    }
}