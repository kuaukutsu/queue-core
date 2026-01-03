<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use kuaukutsu\queue\core\exception\QueuePublishException;

/**
 * @api
 */
interface PublisherInterface
{
    /**
     * @return non-empty-string
     * @throws QueuePublishException
     */
    public function push(SchemaInterface $schema, QueueTask $task, ?QueueContext $context = null): string;

    /**
     * @param iterable<QueueTask> $taskBatch
     * @return list<non-empty-string>
     * @throws QueuePublishException
     */
    public function pushBatch(SchemaInterface $schema, iterable $taskBatch, ?QueueContext $context = null): array;
}
