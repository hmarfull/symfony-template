<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use App\Shared\Domain\Utils\TimestampUtils;
use App\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    public function __construct(
        private readonly string $aggregateId,
        private readonly array $data = [],
        private ?string $id = null,
        private ?int $occurredAt = null,
        private readonly array $metadata = [],
    ) {
        $this->id = $id ?: Uuid::random()->value();
        $this->guardAggregateId($aggregateId);
        DomainEventGuard::guard($data, $this->rules(), get_called_class());

        $this->occurredAt   = $occurredAt ?: TimestampUtils::getNowMillis();
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function occurredAt(): ?int
    {
        return $this->occurredAt;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

}