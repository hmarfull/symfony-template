<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Domain;

use DateTimeImmutable;

final readonly class Guest
{
    public function __construct(
        private string            $name,
        private string            $lastname,
        private DateTimeImmutable $birthdate,
        private string            $passport,
        private string            $country,
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function birthdate(): DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function passport(): string
    {
        return $this->passport;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function age(): int
    {
        return intval($this->birthdate->diff(new DateTimeImmutable("now"))->format("%y"));
    }

    public function toPlain(): array
    {
        return [
            "name" => $this->name,
            "lastname" => $this->lastname,
            "birthdate" => $this->birthdate,
            "passport" => $this->passport,
            "country" => $this->country,
            "age" => $this->age(),
        ];
    }
}