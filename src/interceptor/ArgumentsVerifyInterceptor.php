<?php

declare(strict_types=1);

namespace kuaukutsu\queue\core\interceptor;

use Override;
use kuaukutsu\queue\core\exception\FactoryException;
use kuaukutsu\queue\core\handler\HandlerInterface;
use kuaukutsu\queue\core\QueueMessage;

/**
 * @api
 */
final readonly class ArgumentsVerifyInterceptor implements InterceptorInterface
{
    #[Override]
    public function intercept(QueueMessage $message, HandlerInterface $handler): void
    {
        $taskArgs = array_keys($message->task->arguments);
        $targetArgs = array_keys(get_class_vars($message->task->target));

        if (
            $targetArgs !== []
            && (count($targetArgs) !== count($taskArgs) || array_diff($targetArgs, $taskArgs) !== [])
        ) {
            throw new FactoryException('Arguments of the target do not match.');
        }

        $handler->handle($message);
    }
}
