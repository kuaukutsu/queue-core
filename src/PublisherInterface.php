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
     * @throws QueuePublishException
     */
    public function push(SchemaInterface $schema, QueueTask $task, ?QueueContext $context = null): string;

    /**
     * @param list<QueueTask> $taskBatch
     * @return list<non-empty-string>
     * @throws QueuePublishException
     */
    public function pushBatch(SchemaInterface $schema, array $taskBatch, ?QueueContext $context = null): array;
}
