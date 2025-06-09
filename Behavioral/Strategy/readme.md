# Strategy Pattern

## Definition
Define a family of algorithms, encapsulate each one, and make them interchangeable.

## Understanding the Strategy Pattern
The Strategy pattern is a **behavioral design pattern** that enables selecting an algorithm at runtime. It defines a family of algorithms, encapsulates each one, and makes them interchangeable. The pattern allows the algorithm to vary independently from clients that use it.

---

## Problem
Imagine you're developing an application that needs to implement various algorithms for different operations, such as:

- Data validation
- Sorting
- Payment processing

As your application grows, you'll end up with many conditional statements to choose the right algorithm. This leads to:

- Hard-to-maintain code
- Violation of the Open/Closed Principle
- Difficulty adding new algorithms without modifying existing code

---

## Solution
The Strategy Pattern suggests:

- Defining a family of algorithms
- Placing each one into a separate class
- Making them interchangeable at runtime

This isolates the algorithm implementation from the code that uses it, allowing you to vary or add algorithms independently.

---

## Structure

<img src="./strategy-pattern.svg" alt="strategy image">

- **Strategy**: Declares a common interface for all supported algorithms.
- **Concrete Strategies**: Implement the different variations of an algorithm.
- **Context**: Maintains a reference to a Strategy object and uses it.
- **Client**: Creates a strategy and sets it in the context.

---

## When to Use

- You need different variants of an algorithm.
- You have multiple classes differing only in behavior.
- You want to isolate algorithm details from users.
- You want to adhere to the Open/Closed Principle.

---

## Benefits

✅ Algorithms are interchangeable at runtime  
✅ Implementation details are hidden  
✅ Promotes composition over inheritance  
✅ New strategies can be added without changing existing code

---

## Real-World Use Cases

- Sorting Algorithms  
- Payment Processing  
- Compression Techniques  
- Authentication (OAuth, JWT, etc.)  
- Tax Calculation by Region  

---

## JavaScript Example: Payment Strategies

```js
// Strategy Interface
class PaymentStrategy {
  pay(amount) {
    throw new Error("pay() must be implemented");
  }
}

// Concrete Strategies
class CreditCardStrategy extends PaymentStrategy {
  constructor(cardNumber, name, cvv, expirationDate) {
    super();
    this.cardNumber = cardNumber;
    this.name = name;
    this.cvv = cvv;
    this.expirationDate = expirationDate;
  }

  pay(amount) {
    console.log(`Paid $${amount} using Credit Card`);
  }
}

class PayPalStrategy extends PaymentStrategy {
  constructor(email, password) {
    super();
    this.email = email;
    this.password = password;
  }

  pay(amount) {
    console.log(`Paid $${amount} using PayPal`);
  }
}

class CryptoStrategy extends PaymentStrategy {
  constructor(walletAddress) {
    super();
    this.walletAddress = walletAddress;
  }

  pay(amount) {
    console.log(`Paid $${amount} using Crypto`);
  }
}

// Context
class ShoppingCart {
  constructor() {
    this.items = [];
    this.paymentStrategy = null;
  }

  addItem(item) {
    this.items.push(item);
  }

  setPaymentStrategy(strategy) {
    this.paymentStrategy = strategy;
  }

  calculateTotal() {
    return this.items.reduce((sum, item) => sum + item.price, 0);
  }

  checkout() {
    if (!this.paymentStrategy) {
      throw new Error("Payment strategy not set.");
    }
    const total = this.calculateTotal();
    this.paymentStrategy.pay(total);
  }
}

// Usage
const cart = new ShoppingCart();
cart.addItem({ name: "Product 1", price: 100 });
cart.addItem({ name: "Product 2", price: 50 });

cart.setPaymentStrategy(new CreditCardStrategy("1234 5678 9012 3456", "John Doe", "123", "12/25"));
cart.checkout();

cart.setPaymentStrategy(new PayPalStrategy("john@example.com", "password123"));
cart.checkout();
