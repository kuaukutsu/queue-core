<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

use kuaukutsu\queue\core\exception\QueueConsumeException;

/**
 * @api
 */
interface ConsumerInterface
{
    /**
     * @note is a blocking command.
     * @throws QueueConsumeException
     */
    public function consume(SchemaInterface $schema): void;

    public function disconnect(): void;
}
