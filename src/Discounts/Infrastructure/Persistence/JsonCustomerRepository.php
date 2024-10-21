<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Persistence;

use App\Discounts\Domain\Customer;
use App\Discounts\Domain\Exceptions\CustomerNotFound;
use App\Discounts\Domain\Repositories\CustomerRepository;
use function Lambdish\Phunctional\filter;

class JsonCustomerRepository implements CustomerRepository
{
    private array $customers;

    public function __construct()
    {
        $this->customers = json_decode('[
          {
            "id": "1",
            "name": "Coca Cola",
            "since": "2014-06-28",
            "revenue": "492.12"
          },
          {
            "id": "2",
            "name": "Teamleader",
            "since": "2015-01-15",
            "revenue": "1505.95"
          },
          {
            "id": "3",
            "name": "Jeroen De Wit",
            "since": "2016-02-11",
            "revenue": "0.00"
          }
        ]', true);
    }

    /**
     * @inheritDoc
     */
    public function getById(string $id): Customer
    {
        $customer = filter(function (array $customer) use ($id) {
            if ($customer["id"] !== $id) {
                return null;
            }
            return $customer;
        }, $this->customers);

        $customer = reset($customer);

        if ([] === $customer) {
            throw CustomerNotFound::withId($id);
        }

        return new Customer($customer["id"], (float) $customer["revenue"]);
    }
}