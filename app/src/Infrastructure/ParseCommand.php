<?php

namespace App\Infrastructure;

use App\Domain\Airline;
use App\Domain\Airplane;
use App\Domain\Flight;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Services\FlightService;

#[AsCommand(name: 'parse', hidden: false)]
class ParseCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $flights = (new FlightService())->getFlights();
        $output->writeln([
            $flights
        ]);
        return Command::SUCCESS;
    }
}