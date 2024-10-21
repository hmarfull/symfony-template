<?php

declare(strict_types=1);

namespace App\Tests\Discounts\Application;

use App\Discounts\Application\CalculateOrderDiscountQuery;
use App\Discounts\Application\CalculateOrderDiscountQueryHandler;
use App\Discounts\Domain\Category;
use App\Discounts\Domain\Customer;
use App\Discounts\Domain\DiscountApplicator;
use App\Discounts\Domain\Order;
use App\Discounts\Domain\Product;
use App\Discounts\Domain\Repositories\CustomerRepository;
use App\Discounts\Domain\Repositories\ProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CalculateOrderDiscountQueryHandlerTest extends TestCase
{
    private CalculateOrderDiscountQueryHandler $queryHandler;
    private CustomerRepository|MockObject $customerRepository;
    private ProductRepository|MockObject $productRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $orderDiscountCalculator = new DiscountApplicator($this->customerRepository, $this->productRepository);

        $this->queryHandler = new CalculateOrderDiscountQueryHandler($orderDiscountCalculator);
    }

    public function testApplyOrderDiscountByRevenue(): void 
    {
        $orderData = json_decode('{
          "id": "2",
          "customer-id": "2",
          "items": [
            {
              "product-id": "B102",
              "quantity": "5",
              "unit-price": "4.99",
              "total": "24.95"
            }
          ],
          "total": "24.95"
        }', true);

        $order = Order::fromArray($orderData);

        $customer = new Customer($order->customerId(), 1000);

        $query = new CalculateOrderDiscountQuery($orderData);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with($order->customerId())
            ->willReturn($customer);

        $response = ($this->queryHandler)($query);

        $expectedDiscount = $order->total() * 0.1;

        $this->assertEquals($expectedDiscount, $response->discount());
    }

    public function testDoNotApplyOrderDiscountByRevenue(): void
    {
        $orderData = json_decode('{
          "id": "2",
          "customer-id": "9",
          "items": [
            {
              "product-id": "B102",
              "quantity": "5",
              "unit-price": "4.99",
              "total": "24.95"
            }
          ],
          "total": "24.95"
        }', true);

        $order = Order::fromArray($orderData);

        $customer = new Customer($order->customerId(), 10);

        $query = new CalculateOrderDiscountQuery($orderData);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with($order->customerId())
            ->willReturn($customer);

        $response = ($this->queryHandler)($query);

        $expectedDiscount = 0;

        $this->assertEquals($expectedDiscount, $response->discount());
    }

    public function testApplyOrderDiscountBySwitchQuantity(): void
    {
        $orderData = json_decode('{
          "id": "1",
          "customer-id": "1",
          "items": [
            {
              "product-id": "B102",
              "quantity": "10",
              "unit-price": "4.99",
              "total": "49.90"
            }
          ],
          "total": "49.90"
        }', true);

        $order = Order::fromArray($orderData);

        $customer = new Customer($order->customerId(), 10);

        $query = new CalculateOrderDiscountQuery($orderData);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with($order->customerId())
            ->willReturn($customer);

        $productId = $order->items()->first()->productId();
        $this->productRepository
            ->expects($this->any())
            ->method('getById')
            ->with($productId)
            ->willReturn(new Product($productId, new Category(2)));

        $response = ($this->queryHandler)($query);

        $expectedDiscount = $order->items()->first()->unitPrice();

        $this->assertEquals($expectedDiscount, $response->discount());
    }

    public function testApplyOrderDiscountByToolQuantity(): void
    {
        $orderData = json_decode('{
          "id": "3",
          "customer-id": "3",
          "items": [
            {
              "product-id": "A101",
              "quantity": "2",
              "unit-price": "9.75",
              "total": "19.50"
            },
            {
              "product-id": "A102",
              "quantity": "1",
              "unit-price": "49.50",
              "total": "49.50"
            }
          ],
          "total": "69.00"
        }', true);

        $order = Order::fromArray($orderData);

        $customer = new Customer($order->customerId(), 10);

        $query = new CalculateOrderDiscountQuery($orderData);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with($order->customerId())
            ->willReturn($customer);

        $productIdA = $order->items()->all()[0]->productId();
        $productIdB = $order->items()->all()[1]->productId();
        $this->productRepository
            ->expects($this->any())
            ->method('getById')
            ->willReturnOnConsecutiveCalls(
                new Product($productIdA, new Category(1)),
                new Product($productIdB, new Category(1))
            );

        $response = ($this->queryHandler)($query);

        $expectedDiscount = $order->items()->all()[0]->unitPrice() * 0.2;

        $this->assertEquals($expectedDiscount, $response->discount());
    }
}