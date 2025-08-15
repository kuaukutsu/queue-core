<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\interceptor;

use Override;
use Amp\Cache\Cache;
use Amp\Sync\KeyedMutex;
use kuaukutsu\queue\core\QueueMessage;
use kuaukutsu\queue\core\handler\HandlerInterface;

/**
 * @api
 */
final readonly class ExactlyOnceInterceptor implements InterceptorInterface
{
    /**
     * @param non-negative-int $ttl Time in seconds. Default 10 min.
     */
    public function __construct(
        private Cache $cache,
        private KeyedMutex $mutex,
        private int $ttl = 600,
    ) {
    }

    #[Override]
    public function intercept(QueueMessage $message, HandlerInterface $handler): void
    {
        $lock = $this->mutex->acquire($message->task->getUuid());
        try {
            if ($this->cache->get($message->task->getUuid()) !== null) {
                // interrupt execution
                return;
            }

            $this->cache->set($message->task->getUuid(), 1, $this->ttl);
        } finally {
            $lock->release();
        }

        $handler->handle($message);
    }
}
