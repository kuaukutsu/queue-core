<?php

/** @noinspection PhpComposerExtensionStubsInspection extension_loaded('igbinary') */

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use InvalidArgumentException;
use kuaukutsu\queue\core\exception\IgbinaryException;

/**
 * @api
 */
final readonly class QueueMessageBinary
{
    public function __construct(
        public QueueTask $task,
        public QueueContext $context,
    ) {
    }

    /**
     * @return non-empty-string
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function makeMessage(QueueTask $task, QueueContext $context): string
    {
        if (extension_loaded('igbinary') === false) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new IgbinaryException();
        }

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
     * @throws InvalidArgumentException if Message violates protocol
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function makeFromMessage(string $message): self
    {
        if (extension_loaded('igbinary') === false) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new IgbinaryException();
        }

        $container = igbinary_unserialize($message);
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
