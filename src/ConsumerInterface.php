<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Throwable;
use kuaukutsu\queue\core\exception\QueueConsumeException;

/**
 * @api
 */
interface ConsumerInterface
{
    /**
     * @param ?callable(string|null, Throwable): void $catch
     * @throws QueueConsumeException
     */
    public function consume(SchemaInterface $schema, ?callable $catch = null): void;
}
