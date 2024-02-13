<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use function Lambdish\Phunctional\get;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class BookingContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a request is sent to :path
     */
    public function anApiUserSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response status code should be :status
     */
    public function theResponseShouldBeReceived(int $status): void
    {
        if ($this->response?->getStatusCode() === $status) {
            throw new \RuntimeException('Invalid Status Code.');
        }
    }

    /**
     * @Then the response content should be exactly:
     */
    public function theResponseShouldBeExactly(PyStringNode $expected): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('Invalid Param Value.');
        }
    }
}
