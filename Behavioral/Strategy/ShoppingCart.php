<?php 

namespace Behavioral\Strategy;

use Behavioral\Strategy\PaymentStrategy\PaymentStrategyInterface;
use Exception;

// This is the ShoppingCart class that uses the Strategy pattern
// It allows adding items and setting a payment strategy for checkout
// The payment strategy can be changed at runtime, allowing for flexible payment options
class ShoppingCart {
    private array $items = [];
    private ? PaymentStrategyInterface $paymentStrategy = null;
    
    public function addItem(string $item , float $price):void {
        $this->items[] = ['item' => $item , 'price' => $price];
    }

    public function setPaymentStrategy(PaymentStrategyInterface $paymentStrategy): void {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function calculateTotal():float {
        return array_reduce($this->items, fn($total, $item) => $total + $item['price'], 0);
    }

    public function checkout(): bool {
        if(!$this->paymentStrategy) {
            throw new Exception("No payment strategy set.");
        }

        $amount = $this->calculateTotal();
        return $this->paymentStrategy->pay($amount);
    }
}