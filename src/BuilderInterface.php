<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Closure;
use Throwable;
use kuaukutsu\queue\core\interceptor\InterceptorInterface;

/**
 * @api
 */
interface BuilderInterface
{
    /**
     * @param Closure(string|null, Throwable):void $catch
     */
    public function withCatch(Closure $catch): self;

    public function withInterceptors(InterceptorInterface ...$interceptor): self;

    public function buildPublisher(): PublisherInterface;

    public function buildConsumer(): ConsumerInterface;
}
