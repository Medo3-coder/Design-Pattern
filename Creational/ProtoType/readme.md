### **Prototype Design Pattern**

The **Prototype Design Pattern** is a creational design pattern that allows creating new objects by copying an existing object, known as the prototype. Instead of instantiating new objects directly, the Prototype Pattern enables you to duplicate an object and customize it without altering the original.

---

### **Key Characteristics**
1. **Cloning:** Objects are created by cloning an existing object.
2. **Efficient Creation:** Avoids creating objects from scratch, which can be resource-intensive.
3. **Customization:** Allows modifying cloned objects without affecting the original.

---

### **Problem It Solves**
Creating complex objects repeatedly can be expensive in terms of time and resources. For example:
- If the creation of an object involves expensive operations (e.g., fetching data from an API, initializing large data structures, or performing computations).
- If you need many similar objects with minor differences, creating them manually can be tedious and error-prone.

---

### **Real-World Example**
#### **Problem:**
Consider a graphics editor application. You need to create multiple shapes (like circles, rectangles, etc.), each with specific properties (size, color, position). Creating these shapes from scratch every time is inefficient. Copying and modifying an existing shape saves resources.

---

#### **Solution Using Prototype Pattern**
- You define a `Shape` object as a prototype.
- Clone the prototype and make minor adjustments to create new shapes.

---

### **Example Code**

#### **Prototype Interface**
```php
interface Prototype {
    public function clone(): Prototype;
}
```

#### **Concrete Prototype (Shape Class)**
```php
class Shape implements Prototype {
    private $type;
    private $color;
    private $position;

    public function __construct($type, $color, $position) {
        $this->type = $type;
        $this->color = $color;
        $this->position = $position;
    }

    public function clone(): Prototype {
        return new Shape($this->type, $this->color, $this->position);
    }

    public function setPosition(string $position): void {
        $this->position = $position;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function getPosition(): string {
        return $this->position;
    }
}
```
#### **Unit Test**
```php
use PHPUnit\Framework\TestCase;
use Creational\Prototype\Shape;

class PrototypeTest extends TestCase {

    protected $circlePrototype;

    protected function setUp(): void {
        $this->circlePrototype = new Shape("Circle", "Red", "0,0");
    }

    public function testCloneCreatesNewInstance() {
        $circle1 = $this->circlePrototype->clone();
        $circle2 = $this->circlePrototype->clone();

        $this->assertNotSame($this->circlePrototype, $circle1);
        $this->assertNotSame($circle1, $circle2);
    }

    public function testCloneRetainsOriginalProperties() {
        $clonedCircle = $this->circlePrototype->clone();

        $this->assertEquals("Circle", $clonedCircle->getType());
        $this->assertEquals("Red", $clonedCircle->getColor());
        $this->assertEquals("0,0", $clonedCircle->getPosition());
    }

    public function testCloneCanBeCustomized() {
        $circle1 = $this->circlePrototype->clone();
        $circle1->setPosition("10,10");

        $this->assertEquals("10,10", $circle1->getPosition());
        $this->assertEquals("0,0", $this->circlePrototype->getPosition());
    }
}
```

#### **Client Code**
```php
// Original shape
$circlePrototype = new Shape("Circle", "Red", "0,0");

// Clone and modify
$circle1 = $circlePrototype->clone();
$circle1->setPosition("10,10");

$circle2 = $circlePrototype->clone();
$circle2->setPosition("20,20");

echo $circle1->getInfo() . PHP_EOL; // Shape: Circle, Color: Red, Position: 10,10
echo $circle2->getInfo() . PHP_EOL; // Shape: Circle, Color: Red, Position: 20,20
```

---

### **Real-World Analogy**
Think of prototyping as using a **rubber stamp**:
- The stamp acts as the prototype.
- Each impression on paper is a clone of the stamp.
- You can change the paper, ink color, or position without altering the stamp itself.

---

### **When to Use**
1. **Performance Optimization:**  
   Use the Prototype Pattern when object creation is resource-intensive, and you want to minimize initialization costs.
   
2. **Object Variability:**  
   When you need multiple similar objects with slight variations.

3. **Decoupling:**  
   The pattern decouples the client from knowing how the objects are created, promoting flexibility.

---

### **Advantages**
1. **Reduces Complexity:**  
   Simplifies object creation by cloning existing ones.
   
2. **Efficient Resource Usage:**  
   Avoids costly initializations.
   
3. **Customizable Clones:**  
   Allows creating objects with modified properties without affecting the original.

---

### **Disadvantages**
1. **Deep Copy Complexity:**  
   If an object contains nested objects, implementing deep copying can be complex.
   
2. **Requires Cloning Logic:**  
   Each class must implement cloning, which can increase maintenance.

---

### **Conclusion**
The Prototype Pattern is particularly useful in applications where creating complex objects from scratch is expensive, and you need many similar objects. It strikes a balance between performance and flexibility by reusing existing objects as templates.