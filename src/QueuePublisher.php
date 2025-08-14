<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use kuaukutsu\queue\core\exception\QueuePublishException;

/**
 * @api
 */
interface QueuePublisher
{
    /**
     * @throws QueuePublishException
     */
    public function push(SchemaInterface $schema, QueueTask $task, ?QueueContext $context = null): string;
}
