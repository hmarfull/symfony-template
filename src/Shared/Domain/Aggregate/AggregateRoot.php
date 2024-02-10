<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final protected function raise(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final public function pullDomainEvents(): array
    {
        return $this->domainEvents;
    }

}