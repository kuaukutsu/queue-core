<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Serializable;
use Ramsey\Uuid\Uuid;
use kuaukutsu\queue\core\internal\SerializableDeprecated;

/**
 * @api
 */
final readonly class QueueTask implements Serializable
{
    use SerializableDeprecated;

    /**
     * @var non-empty-string format: UUID
     */
    private string $uuid;

    /**
     * @param class-string<TaskInterface> $target
     * @param array<non-empty-string, mixed> $arguments
     */
    public function __construct(
        public string $target,
        public array $arguments = [],
    ) {
        $this->uuid = Uuid::uuid7()->toString();
    }

    /**
     * @return non-empty-string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function __serialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'target' => $this->target,
            'arguments' => $this->arguments,
        ];
    }

    /**
     * @param array{
     *     "uuid": non-empty-string,
     *     "target": class-string<TaskInterface>,
     *     "arguments": array<non-empty-string, mixed>,
     * } $data
     */
    public function __unserialize(array $data): void
    {
        $this->uuid = $data['uuid'];
        $this->target = $data['target'];
        $this->arguments = $data['arguments'];
    }
}
