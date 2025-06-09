<?php

namespace Behavioral\Strategy\PaymentStrategy;

// This is the interface for the payment strategy
// It defines a method for processing payments
interface PaymentStrategyInterface {
    public function pay(float $amout): bool;
}