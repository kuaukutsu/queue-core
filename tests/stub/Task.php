<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\tests\stub;

use kuaukutsu\queue\core\QueueContext;
use kuaukutsu\queue\core\TaskInterface;

final class Task implements TaskInterface
{
    public function __construct(Person $person)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(QueueContext $context): void
    {
    }
}
