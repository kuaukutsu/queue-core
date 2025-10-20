<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\exception;

use Error;

final class UnsupportedException extends Error
{
    /**
     * @param non-empty-string $message
     */
    public function __construct(string $message = 'Unsupported operation.')
    {
        parent::__construct($message);
    }
}
