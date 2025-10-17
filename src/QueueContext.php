<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Serializable;
use kuaukutsu\queue\core\internal\SerializableDeprecated;

/**
 * @api
 */
final readonly class QueueContext implements Serializable
{
    use SerializableDeprecated;

    /**
     * @param non-negative-int $attempt
     * @param non-empty-string $routingKey
     * @param array<non-empty-string, mixed> $external Внешние атрибуты.
     *                             Например, requestId или спеуцифичные для метрик атрибуты.
     */
    private function __construct(
        public int $attempt,
        public string $routingKey,
        public string $createdAt,
        public array $external = [],
    ) {
    }

    public static function make(SchemaInterface $schema): self
    {
        return new self(
            attempt: 0,
            routingKey: $schema->getRoutingKey(),
            createdAt: gmdate('c'),
            external: [],
        );
    }

    /**
     * @param array<non-empty-string, mixed> $external
     */
    public function withExternal(array $external): self
    {
        return new self(
            attempt: $this->attempt,
            routingKey: $this->routingKey,
            createdAt: $this->createdAt,
            external: $external,
        );
    }

    public function incrAttempt(): self
    {
        return new self(
            attempt: $this->attempt + 1,
            routingKey: $this->routingKey,
            createdAt: $this->createdAt,
            external: $this->external,
        );
    }

    public function __serialize(): array
    {
        return [
            'attempt' => $this->attempt,
            'routingKey' => $this->routingKey,
            'createdAt' => $this->createdAt,
            'external' => $this->external,
        ];
    }

    /**
     * @param array{
     *     "attempt": non-negative-int,
     *     "routingKey": non-empty-string,
     *     "createdAt": non-empty-string,
     *     "external": array<non-empty-string, mixed>,
     * } $data
     */
    public function __unserialize(array $data): void
    {
        $this->attempt = $data['attempt'];
        $this->routingKey = $data['routingKey'];
        $this->createdAt = $data['createdAt'];
        $this->external = $data['external'];
    }
}
