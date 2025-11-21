<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Throwable;
use kuaukutsu\queue\core\interceptor\InterceptorInterface;

/**
 * @api
 */
interface BuilderInterface
{
    /**
     * @param callable(string|null, Throwable):void $catch
     */
    public function withCatch(callable $catch): self;

    public function withInterceptors(InterceptorInterface ...$interceptor): self;

    public function buildPublisher(): PublisherInterface;

    public function buildConsumer(): ConsumerInterface;
}
