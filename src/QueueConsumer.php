<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Throwable;
use kuaukutsu\queue\core\exception\QueueConsumeException;

/**
 * @api
 */
interface QueueConsumer
{
    /**
     * @param ?callable(string, Throwable): void $catch
     * @throws QueueConsumeException
     */
    public function consume(SchemaInterface $schema, ?callable $catch = null): void;
}
