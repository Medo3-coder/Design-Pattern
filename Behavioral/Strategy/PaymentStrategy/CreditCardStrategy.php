<?php
namespace Behavioral\Strategy\PaymentStrategy;

class CreditCardStrategy implements PaymentStrategyInterface
{
    private string $cardNumber;
    private string $name;
    private string $cvv;
    private string $expirationDate;

    public function __construct(string $cardNumber, string $name, string $cvv, string $expirationDate)
    {
        $this->cardNumber     = $cardNumber;
        $this->name           = $name;
        $this->cvv            = $cvv;
        $this->expirationDate = $expirationDate;
    }

    public function pay(float $amount): bool
    {
        echo "Paid \${$amount} using Credit Card.\n";
        return true;
    }
}
