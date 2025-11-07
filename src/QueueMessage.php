<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use InvalidArgumentException;

/**
 * @api
 */
final readonly class QueueMessage
{
    private function __construct(
        public QueueTask $task,
        public QueueContext $context,
    ) {
    }

    /**
     * @return non-empty-string
     */
    public static function makeMessage(QueueTask $task, QueueContext $context): string
    {
        if (extension_loaded('igbinary')) {
            /**
             * @var non-empty-string
             */
            return igbinary_serialize(
                [
                    $task,
                    $context,
                ]
            );
        }

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
     * @throws InvalidArgumentException if Message violates protocol
     */
    public static function makeFromMessage(string $message): self
    {
        if ($message === 'b:0;'
            || $message === 'N;'
            || str_starts_with($message, 'a:2') === false
        ) {
            throw new InvalidArgumentException(
                'Message must contain an array of two elements: QueueTask and QueueContext.'
            );
        }

        if (extension_loaded('igbinary')) {
            $container = igbinary_unserialize($message);
        } else {
            $container = unserialize(
                $message,
                [
                    'allowed_classes' => [
                        QueueTask::class,
                        QueueContext::class,
                    ],

                ]
            );
        }

        if (
            is_array($container) && isset($container[0], $container[1])
            && $container[0] instanceof QueueTask
            && $container[1] instanceof QueueContext
        ) {
            return new self($container[0], $container[1]);
        }

        throw new InvalidArgumentException('Message must contain QueueTask and QueueContext.');
    }
}
