<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core;

interface SchemaInterface
{
    /**
     * @return non-empty-string
     */
    public function getRoutingKey(): string;
}
