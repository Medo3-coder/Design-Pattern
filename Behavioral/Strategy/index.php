<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Behavioral\Strategy\PaymentStrategy\CreditCardStrategy;
use Behavioral\Strategy\PaymentStrategy\CryptoStrategy;
use Behavioral\Strategy\PaymentStrategy\PayPalStrategy;
use Behavioral\Strategy\ShoppingCart;

// Create cart and add items
$cart = new ShoppingCart();
$cart->addItem("Product 1", 100.00);
$cart->addItem("Product 2", 50.00);

// Use Credit Card strategy
$cart->setPaymentStrategy(new CreditCardStrategy("1234 5678 9012 3456", "John Doe", "123", "12/25"));
$cart->checkout();

// Switch to PayPal strategy
$cart->setPaymentStrategy(new PayPalStrategy("johndoe@example.com", "secret123"));
$cart->checkout();

// Switch to Crypto strategy
$cart->setPaymentStrategy(new CryptoStrategy("0xABCDEF123456"));
$cart->checkout();
