<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\tests\stub;

final readonly class Person
{
    public function __construct(public string $name)
    {
    }
}
