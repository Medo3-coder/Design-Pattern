<?php

namespace Behavioral\Strategy\PaymentStrategy;

class CryptoStrategy  implements PaymentStrategyInterface
{
    private string $walletAddress; 

    public function __construct(string $walletAddress)
    {
        $this->walletAddress = $walletAddress;
    }
    public function pay(float $amount): bool
    {
        echo "Paid \${$amount} using Crypto.\n";
        return true;
    }
  
}