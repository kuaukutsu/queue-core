<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use kuaukutsu\queue\core\QueueContext;
use kuaukutsu\queue\core\QueueMessage;
use kuaukutsu\queue\core\QueueTask;
use kuaukutsu\queue\core\tests\stub\Person;
use kuaukutsu\queue\core\tests\stub\Schema;
use kuaukutsu\queue\core\tests\stub\Task;

final class MarshallerTest extends TestCase
{
    public function testMarshall(): void
    {
        $task = new QueueTask(Task::class, ['person' => new Person('test')]);
        $message = QueueMessage::makeMessage(
            $task,
            QueueContext::make(Schema::test)
        );

        self::assertStringContainsString(Task::class, $message);
        self::assertStringContainsString($task->getUuid(), $message);
    }

    public function testUnmarshall(): void
    {
        $task = new QueueTask(Task::class, ['person' => new Person('test')]);
        $message = QueueMessage::makeMessage(
            $task,
            QueueContext::make(Schema::test)
        );

        $queueMesage = QueueMessage::makeFromMessage($message);
        self::assertEquals($task->getUuid(), $queueMesage->task->getUuid());
    }

    public function testUnmarshallMessageEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        QueueMessage::makeFromMessage('');
    }

    public function testUnmarshallMessageNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        QueueMessage::makeFromMessage(serialize(''));
    }
}
