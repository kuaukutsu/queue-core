<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Throwable;

/**
 * Deferred Task.
 */
interface TaskInterface
{
    /**
     * @throws Throwable while executing a deferred task.
     */
    public function handle(QueueContext $context): void;
}
