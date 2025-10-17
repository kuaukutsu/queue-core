<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\exception;

use Exception;
use Throwable;

final class IgbinaryException extends Exception
{
    /**
     * @param non-empty-string $message
     */
    public function __construct(string $message = 'The igbinary extension is not loaded.', ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
