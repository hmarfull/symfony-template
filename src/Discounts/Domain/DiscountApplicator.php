<?php

declare(strict_types=1);

namespace App\Discounts\Domain;

use App\Discounts\Domain\Exceptions\CustomerNotFound;
use App\Discounts\Domain\Exceptions\ProductNotFound;
use App\Discounts\Domain\Repositories\CustomerRepository;
use App\Discounts\Domain\Repositories\ProductRepository;

use function \Lambdish\Phunctional\each;

class DiscountApplicator
{
    private const int REVENUE_THRESHOLD = 1000;
    private const int SWITCHES_THRESHOLD = 6;
    private const int TOOLS_THRESHOLD = 2;


    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly ProductRepository  $productRepository,
    )
    {
    }

    public function __invoke(Order $order): void
    {
        $this->applyDiscountByRevenue($order);
        $this->applyDiscountBySwitchQuantity($order);
        $this->applyDiscountByToolQuantity($order);
    }

    private function applyDiscountByRevenue(Order $order): void
    {
        try {
            $customer = $this->customerRepository->getById($order->customerId());

            if (self::REVENUE_THRESHOLD <= $customer->revenue()) {
                $order->addDiscount($order->total() * 0.1);
            }
        } catch (CustomerNotFound) {
            return;
        }
    }

    private function applyDiscountBySwitchQuantity(Order $order): void
    {
        $items = $order->items()->getItemsWithQuantityOverAThreshold(self::SWITCHES_THRESHOLD);

        each(function (Item $item) use (&$order): void {
            try {
                $product = $this->productRepository->getById($item->productId());

                if ($product->category()->isSwitch()) {
                    $freeUnits = $this->calculateFreeUnits($item->quantity());

                    $order->addDiscount($item->unitPrice() * $freeUnits);
                }
            } catch (ProductNotFound) {
                return;
            }
        }, $items);
    }

    private function calculateFreeUnits(int $quantity): int
    {
        return (int)($quantity / self::SWITCHES_THRESHOLD);
    }

    private function applyDiscountByToolQuantity(Order $order): void
    {
        $numberOfTools = 0;
        $lowestToolPrice = 0;
        each(function (Item $item) use (&$numberOfTools, &$lowestToolPrice): void {
            try {
                $product = $this->productRepository->getById($item->productId());

                if ($product->category()->isTool()) {
                    $numberOfTools++;
                    $lowestToolPrice = $lowestToolPrice === 0 ?
                        $item->unitPrice() : min($lowestToolPrice, $item->unitPrice());
                }
            } catch (ProductNotFound) {
                return;
            }
        }, $order->items()->all());

        if ($numberOfTools >= self::TOOLS_THRESHOLD) {
            $order->addDiscount($lowestToolPrice * 0.2);
        }
    }
}