<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use LogicException;

final readonly class QueueMessage
{
    public function __construct(
        public QueueTask $task,
        public QueueContext $context,
    ) {
    }

    /**
     * @return non-empty-string
     */
    public static function makeMessage(QueueTask $task, QueueContext $context): string
    {
        /**
         * @var non-empty-string
         */
        return serialize(
            [
                $task,
                $context,
            ]
        );
    }

    /**
     * @throws LogicException if Message violates protocol
     */
    public static function makeFromMessage(string $message): self
    {
        $container = unserialize(
            $message,
            [
                'allowed_classes' => true,
            ]
        );

        if (
            is_array($container) && isset($container[0], $container[1])
            && $container[0] instanceof QueueTask
            && $container[1] instanceof QueueContext
        ) {
            return new self($container[0], $container[1]);
        }

        throw new LogicException('Message must contain QueueTask and QueueContext.');
    }
}
