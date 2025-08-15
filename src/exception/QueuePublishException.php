<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\exception;

use Throwable;
use RuntimeException;
use kuaukutsu\queue\core\SchemaInterface;

final class QueuePublishException extends RuntimeException
{
    public function __construct(SchemaInterface $schema, Throwable $previous)
    {
        parent::__construct(
            sprintf(
                'Task push to [%s] queue is failed: %s',
                $schema->getRoutingKey(),
                $previous->getMessage()
            ),
            0,
            $previous,
        );
    }
}
