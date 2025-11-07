<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\tests\stub;

use kuaukutsu\queue\core\SchemaInterface;

enum Schema: string implements SchemaInterface
{
    case test = 'test';

    /**
     * @inheritDoc
     */
    public function getRoutingKey(): string
    {
        return $this->value;
    }
}
