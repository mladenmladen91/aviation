<?php

namespace App\Domain;

class Flight
{
    public function __construct(
        private readonly string $registration,
        private readonly string $from,
        private readonly string $to,
        private readonly \DateTimeImmutable $scheduledStart,
        private readonly \DateTimeImmutable $scheduledEnd,
        private readonly \DateTimeImmutable $actualStart,
        private readonly \DateTimeImmutable $actualEnd,
    )
    {
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getScheduledStart(): \DateTimeImmutable
    {
        return $this->scheduledStart;
    }

    public function getScheduledEnd(): \DateTimeImmutable
    {
        return $this->scheduledEnd;
    }

    public function getActualStart(): \DateTimeImmutable
    {
        return $this->actualStart;
    }

    public function getActualEnd(): \DateTimeImmutable
    {
        return $this->actualEnd;
    }
}