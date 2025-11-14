<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use kuaukutsu\queue\core\interceptor\InterceptorInterface;

/**
 * @api
 */
interface BuilderInterface
{
    public function withInterceptors(InterceptorInterface ...$interceptor): self;

    public function buildPublisher(): PublisherInterface;

    public function buildConsumer(SchemaInterface $schema): ConsumerInterface;
}
