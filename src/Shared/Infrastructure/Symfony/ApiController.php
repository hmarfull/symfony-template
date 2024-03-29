<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Lambdish\Phunctional\each;

abstract class ApiController extends AbstractController
{
    public function __construct(
        private readonly QueryBus          $queryBus,
        private readonly CommandBus        $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    )
    {
        each(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    abstract protected function exceptions(): array;

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}