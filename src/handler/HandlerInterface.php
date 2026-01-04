<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\handler;

use Throwable;
use Psr\Container\ContainerExceptionInterface;
use kuaukutsu\queue\core\QueueMessage;
use kuaukutsu\queue\core\interceptor\InterceptorInterface;

interface HandlerInterface
{
    /**
     * @param InterceptorInterface|class-string<InterceptorInterface> ...$interceptors
     * @throws ContainerExceptionInterface
     * @noinspection PhpDocSignatureInspection
     */
    public function withInterceptors(InterceptorInterface | string ...$interceptors): self;

    /**
     * @throws ContainerExceptionInterface
     * @throws Throwable while executing a deferred task.
     */
    public function handle(QueueMessage $message): void;
}
