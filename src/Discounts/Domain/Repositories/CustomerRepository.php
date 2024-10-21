<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Repositories;

use App\Discounts\Domain\Customer;
use App\Discounts\Domain\Exceptions\CustomerNotFound;

interface CustomerRepository
{
    /** @throws CustomerNotFound */
    public function getById(string $id): Customer;
}