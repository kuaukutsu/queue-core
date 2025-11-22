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
     * @param non-negative-int $attempt Номер попытки, может использоваться при ретраях.
     * @param non-negative-int $timeout seconds. Время на выполнение задачи.
     * @param non-empty-string $routingKey Наименование канала.
     * @param array<non-empty-string, mixed> $external Внешние атрибуты.
     *                             Например, requestId или спеуцифичные для метрик атрибуты.
     */
    private function __construct(
        public int $attempt,
        public int $timeout,
        public string $routingKey,
        public string $createdAt,
        public array $external,
    ) {
    }

    public static function make(SchemaInterface $schema): self
    {
        return new self(
            attempt: 1,
            timeout: 0,
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
            timeout: $this->timeout,
            routingKey: $this->routingKey,
            createdAt: $this->createdAt,
            external: $external,
        );
    }

    /**
     * @param positive-int $timeout
     */
    public function withTimeout(int $timeout): self
    {
        return new self(
            attempt: $this->attempt,
            timeout: $timeout,
            routingKey: $this->routingKey,
            createdAt: $this->createdAt,
            external: $this->external,
        );
    }

    public function incrAttempt(?int $attempt = null): self
    {
        return new self(
            attempt: $attempt ?? $this->attempt + 1,
            timeout: $this->timeout,
            routingKey: $this->routingKey,
            createdAt: $this->createdAt,
            external: $this->external,
        );
    }

    public function __serialize(): array
    {
        return [
            'attempt' => $this->attempt,
            'timeout' => $this->timeout,
            'routingKey' => $this->routingKey,
            'createdAt' => $this->createdAt,
            'external' => $this->external,
        ];
    }

    /**
     * @param array{
     *     "attempt": non-negative-int,
     *     "timeout": non-negative-int,
     *     "routingKey": non-empty-string,
     *     "createdAt": non-empty-string,
     *     "external": array<non-empty-string, mixed>,
     * } $data
     */
    public function __unserialize(array $data): void
    {
        $this->attempt = $data['attempt'];
        $this->timeout = $data['timeout'];
        $this->routingKey = $data['routingKey'];
        $this->createdAt = $data['createdAt'];
        $this->external = $data['external'];
    }
}
