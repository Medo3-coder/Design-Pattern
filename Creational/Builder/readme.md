The **Builder Design Pattern** is a creational design pattern that simplifies the construction of complex objects step-by-step. It is particularly useful when creating objects with many optional parameters or when an object needs to be created in multiple steps. 

---

### **Problem Solved by the Builder Pattern**
1. **Complex Object Construction:** When an object requires multiple steps or configurations, managing its creation can become cumbersome.
2. **Code Readability:** Avoids long, complex constructors with numerous parameters.
3. **Flexibility:** Makes it easy to construct variations of the object without needing to create multiple constructors.

---

### **Real-life Example**
Imagine you are ordering a custom pizza:
- **Problem:** A pizza can have various attributes like size, crust type, sauce type, and a variety of toppings. Managing all these options with multiple constructors or parameters would make the code messy and difficult to maintain.
- **Solution:** Use the Builder pattern to construct the pizza step by step.

---

Below is the **PHP code** implementation of the **Builder Design Pattern** based on the example provided in the diagram for building **Nokia** and **Blackberry** phones:

---

### **PHP Code**

```php
<?php

// 1. Product Class
class Smartphone {
    public $brand;
    public $operatingSystem;
    public $screenSize;
    public $battery;

    public function showSpecifications() {
        echo "Brand: {$this->brand}\n";
        echo "Operating System: {$this->operatingSystem}\n";
        echo "Screen Size: {$this->screenSize}\n";
        echo "Battery: {$this->battery}mAh\n";
        echo "----------------------\n";
    }
}

// 2. Builder Interface
interface SmartphoneBuilder {
    public function setBrand();
    public function setOperatingSystem();
    public function setScreenSize();
    public function setBattery();
    public function getSmartphone(): Smartphone;
}

// 3. Concrete Builder for Nokia
class NokiaBuilder implements SmartphoneBuilder {
    private $smartphone;

    public function __construct() {
        $this->smartphone = new Smartphone();
    }

    public function setBrand() {
        $this->smartphone->brand = "Nokia";
    }

    public function setOperatingSystem() {
        $this->smartphone->operatingSystem = "Symbian";
    }

    public function setScreenSize() {
        $this->smartphone->screenSize = "4.5 inches";
    }

    public function setBattery() {
        $this->smartphone->battery = 2000;
    }

    public function getSmartphone(): Smartphone {
        return $this->smartphone;
    }
}

// 4. Concrete Builder for Blackberry
class BlackberryBuilder implements SmartphoneBuilder {
    private $smartphone;

    public function __construct() {
        $this->smartphone = new Smartphone();
    }

    public function setBrand() {
        $this->smartphone->brand = "Blackberry";
    }

    public function setOperatingSystem() {
        $this->smartphone->operatingSystem = "Blackberry OS";
    }

    public function setScreenSize() {
        $this->smartphone->screenSize = "3.5 inches";
    }

    public function setBattery() {
        $this->smartphone->battery = 1800;
    }

    public function getSmartphone(): Smartphone {
        return $this->smartphone;
    }
}

// 5. Director Class
class Director {
    private $builder;

    public function setBuilder(SmartphoneBuilder $builder) {
        $this->builder = $builder;
    }

    public function buildSmartphone(): Smartphone {
        $this->builder->setBrand();
        $this->builder->setOperatingSystem();
        $this->builder->setScreenSize();
        $this->builder->setBattery();
        return $this->builder->getSmartphone();
    }
}

// 6. Client Code
function clientCode() {
    $director = new Director();

    // Building a Nokia phone
    $nokiaBuilder = new NokiaBuilder();
    $director->setBuilder($nokiaBuilder);
    $nokiaPhone = $director->buildSmartphone();
    echo "Nokia Smartphone Specifications:\n";
    $nokiaPhone->showSpecifications();

    // Building a Blackberry phone
    $blackberryBuilder = new BlackberryBuilder();
    $director->setBuilder($blackberryBuilder);
    $blackberryPhone = $director->buildSmartphone();
    echo "Blackberry Smartphone Specifications:\n";
    $blackberryPhone->showSpecifications();
}

// Execute client code
clientCode();

```

---

### **Explanation**

1. **Product Class (`Smartphone`)**:
   - Represents the complex object being built.
   - Includes properties like `brand`, `operatingSystem`, `screenSize`, and `battery`.
   - Contains a method `showSpecifications()` to display the built product details.

2. **Builder Interface (`SmartphoneBuilder`)**:
   - Declares the steps required to build the product (e.g., `setBrand`, `setOperatingSystem`, etc.).

3. **Concrete Builders**:
   - **`NokiaBuilder`** and **`BlackberryBuilder`** implement the `SmartphoneBuilder` interface.
   - Each defines the specific steps to build a Nokia or Blackberry smartphone.

4. **Director Class**:
   - The **Director** (`Director`) encapsulates the construction process.
   - It uses a builder to construct a product step-by-step in a consistent manner.

5. **Client Code**:
   - Creates the Director and sets the required builder (Nokia or Blackberry).
   - Calls the `buildSmartphone()` method of the Director to get the fully built product.
   - Displays the specifications of the created smartphone.

---

### **Output**

```
Nokia Smartphone Specifications:
Brand: Nokia
Operating System: Symbian
Screen Size: 4.5 inches
Battery: 2000mAh
----------------------
Blackberry Smartphone Specifications:
Brand: Blackberry
Operating System: Blackberry OS
Screen Size: 3.5 inches
Battery: 1800mAh
----------------------
```

This code demonstrates how the **Builder Design Pattern** separates the construction of complex objects from their representation, ensuring flexibility and maintainability.

---

### **Benefits**
- **Readable Code:** You can clearly see the steps for constructing the pizza.
- **Customization:** Easy to customize pizza without creating multiple constructors.
- **Scalability:** Adding new options (like gluten-free crust) becomes straightforward.

---

### **Real-life Applications of Builder Pattern**
1. **Building UI Components:** Frameworks like Flutter use builder patterns to construct UI elements step by step.
2. **Document Creation:** Tools for generating documents or reports.
3. **Database Query Builders:** SQL query builders (e.g., Knex.js) use this pattern to build complex queries.