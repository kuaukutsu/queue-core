<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\internal;

use kuaukutsu\queue\core\exception\UnsupportedException;

trait SerializableDeprecated
{
    /**
     * @throws UnsupportedException
     */
    public function serialize(): never
    {
        throw new UnsupportedException();
    }

    /**
     * @throws UnsupportedException
     */
    public function unserialize(string $data): never
    {
        throw new UnsupportedException();
    }
}
