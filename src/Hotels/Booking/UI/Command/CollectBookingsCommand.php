<?php

declare(strict_types=1);

namespace App\Hotels\Booking\UI\Command;

use App\Hotels\Booking\Application\Populate\PopulateBookingsCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
#[AsCommand(
    name: 'app:bookings:collect',
    description: 'Collect and store bookings from partners.',
    hidden: false,
)]
final class CollectBookingsCommand extends Command
{
    public function __construct(private readonly CommandBus $commandBus,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('since', InputArgument::REQUIRED, 'Date since when we want to gather the bookings in format Y-m-d H:i:s');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $since = $input->getArgument('since');
        $this->commandBus->dispatch(new PopulateBookingsCommand(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $since)));

        return 0;
    }
}