<?php

namespace Behavioral\Strategy\PaymentStrategy;


class PayPalStrategy  implements PaymentStrategyInterface
{
    private string $email;
    private string $password;

    public function __construct(string $email , string $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function pay(float $amount): bool
    {
        echo "Paid \${$amount} using PayPal.\n";
        return true;
    }
}