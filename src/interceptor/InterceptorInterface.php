<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\interceptor;

use Throwable;
use kuaukutsu\queue\core\QueueMessage;
use kuaukutsu\queue\core\handler\HandlerInterface;

interface InterceptorInterface
{
    /**
     * @throws Throwable while executing a deferred task.
     */
    public function intercept(QueueMessage $message, HandlerInterface $handler): void;
}
