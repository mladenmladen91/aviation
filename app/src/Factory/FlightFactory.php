<?php

namespace App\Factory;

use App\Domain\Flight;

class FlightFactory
{

    public function __construct(
        private readonly string $registration,
        private readonly string $from,
        private readonly string $to,
        private readonly \DateTimeImmutable $scheduledStart,
        private readonly \DateTimeImmutable $scheduledEnd,
        private readonly \DateTimeImmutable $actualStart,
        private readonly \DateTimeImmutable $actualEnd,
    ) {
    }

    public function createFlight(): Flight
    {
        return new Flight(
            $this->registration,
            $this->from,
            $this->to,
            $this->scheduledStart,
            $this->scheduledEnd,
            $this->actualStart,
            $this->actualEnd
        );
    }
}
