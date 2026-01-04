<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use Closure;
use Throwable;
use Psr\Container\ContainerExceptionInterface;
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

    /**
     * @param InterceptorInterface|class-string<InterceptorInterface> ...$interceptors
     * @throws ContainerExceptionInterface
     * @noinspection PhpDocSignatureInspection
     */
    public function withInterceptors(InterceptorInterface | string ...$interceptors): self;

    public function buildPublisher(): PublisherInterface;

    public function buildConsumer(): ConsumerInterface;
}
