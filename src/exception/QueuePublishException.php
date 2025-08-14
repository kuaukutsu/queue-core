<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\exception;

use Throwable;
use RuntimeException;
use kuaukutsu\queue\core\SchemaInterface;
use kuaukutsu\queue\core\QueueTask;

final class QueuePublishException extends RuntimeException
{
    public function __construct(QueueTask $task, SchemaInterface $schema, Throwable $previous)
    {
        parent::__construct(
            sprintf(
                '[%s] Task push to [%s] queue is failed: %s',
                $task->target,
                $schema->getRoutingKey(),
                $previous->getMessage()
            ),
            0,
            $previous,
        );
    }
}
