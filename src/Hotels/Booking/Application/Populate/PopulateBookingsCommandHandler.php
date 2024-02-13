<?php

declare(strict_types=1);

namespace App\Hotels\Booking\Application\Populate;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class PopulateBookingsCommandHandler implements CommandHandler
{
    public function __construct(private BookingPopulator $populator)
    {
    }

    public function __invoke(PopulateBookingsCommand $command): void
    {
        ($this->populator)($command->since());
    }
}