<?php

declare(strict_types=1);

namespace App\Tests\Shared\PhpUnit;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\Response;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Throwable;

abstract class UnitTestCase extends MockeryTestCase
{
    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

    protected function assertAskResponse(?Response $expected, Query $query, callable $queryHandler): void
    {
        $actual = $queryHandler($query);

        $this->assertEquals($expected, $actual);
    }

    /** @param class-string<Throwable> $expectedErrorClass */
    protected function assertAskThrowsException(string $expectedErrorClass, Query $query, callable $queryHandler): void
    {
        $this->expectException($expectedErrorClass);

        $queryHandler($query);
    }
}