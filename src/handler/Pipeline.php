<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\handler;

use Override;
use Throwable;
use Psr\Container\ContainerExceptionInterface;
use kuaukutsu\queue\core\exception\FactoryException;
use kuaukutsu\queue\core\interceptor\InterceptorInterface;
use kuaukutsu\queue\core\TaskInterface;
use kuaukutsu\queue\core\QueueMessage;
use kuaukutsu\queue\core\QueueTask;

/**
 * @see https://github.com/spiral/framework/blob/master/src/Interceptors/src/Handler/InterceptorPipeline.php
 */
final class Pipeline implements HandlerInterface
{
    /**
     * @var list<InterceptorInterface>
     */
    private array $interceptors = [];

    private int $position = 0;

    public function __construct(
        private readonly FactoryInterface $factory,
    ) {
    }

    #[Override]
    public function withInterceptors(InterceptorInterface ...$interceptors): self
    {
        $clone = clone $this;
        $clone->interceptors = [];
        foreach ($interceptors as $interceptor) {
            $clone->interceptors[] = $interceptor;
        }

        return $clone;
    }

    #[Override]
    public function handle(QueueMessage $message): void
    {
        if (isset($this->interceptors[$this->position])) {
            $this->interceptors[$this->position]->intercept($message, $this->next());
            return;
        }

        $this->makeHandler($message->task)->handle($message->context);
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function makeHandler(QueueTask $task): TaskInterface
    {
        try {
            $handler = $this->factory->make(
                $task->target,
                $task->arguments,
            );
        } catch (Throwable $exception) {
            throw new FactoryException('Target must implement the QueueHandlerInterface.', $exception);
        }

        if ($handler instanceof TaskInterface) {
            return $handler;
        }

        /** @phpstan-ignore deadCode.unreachable */
        throw new FactoryException('Target must implement the QueueHandlerInterface.');
    }

    private function next(): self
    {
        $pipeline = clone $this;
        ++$pipeline->position;
        return $pipeline;
    }
}
