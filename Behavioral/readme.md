# 🧠 Behavioral Design Patterns – Interview Cheat Sheet

Behavioral design patterns focus on **how objects interact and communicate** to improve **flexibility**, **responsibility delegation**, and **runtime decision-making**, ensuring systems are **maintainable and scalable**.

---

## 🧩 What Are Behavioral Patterns?

- **Purpose**: Define how objects **cooperate** with **loose coupling**.
- **Goal**: Enhance **communication**, manage **responsibilities**, and enable **dynamic behavior changes**.

---

## 🧬 List of Behavioral Design Patterns

| Pattern                  | Intent                                                                 |
|--------------------------|------------------------------------------------------------------------|
| **Strategy**             | Encapsulate interchangeable algorithms and select them at runtime     |
| **Observer**             | Notify dependent objects when state changes (event system)             |
| **Command**              | Encapsulate requests as objects (undo/redo, macros)                    |
| **Chain of Responsibility** | Pass a request through a chain of handlers                          |
| **State**                | Allow an object to alter its behavior when its internal state changes |
| **Mediator**             | Centralize complex communication between related objects               |
| **Memento**              | Capture and restore an object's internal state (undo feature)          |
| **Visitor**              | Add operations to object structures without modifying them            |
| **Iterator**             | Access elements of a collection sequentially without exposing details |
| **Template Method**      | Define the skeleton of an algorithm and allow subclasses to override steps |
| **Interpreter**          | Define a grammar and an interpreter for a language                    |
| **Null Object**          | Use an object with neutral behavior instead of null                  |

---

## 🧪 Quick Use-Cases

- 🧮 **Strategy**: Switch payment methods (credit card, PayPal).
- 🔁 **Observer**: Real-time UI updates (stock tickers, chat apps).
- 🧾 **Command**: Undo/redo in editors, macro recording.
- 🧵 **Chain of Responsibility**: Logging levels, request routing.
- 🧯 **State**: Game character modes, workflow engines.
- 💬 **Mediator**: Chatroom coordination, UI form interactions.
- ♻️ **Memento**: Undo in text editors or design tools.
- 🚶 **Iterator**: Traverse complex collections (databases, lists).
- 🛠️ **Template Method**: Framework hooks, algorithm skeletons.
- 🗣️ **Interpreter**: Query languages, rule engines.
- 🕳️ **Visitor**: Add operations to object hierarchies (e.g., reporting).
- 🚫 **Null Object**: Avoid null checks with default behavior.

---

## 🚀 Real-World Analogies

| Pattern                  | Real-World Example                                  |
|--------------------------|-----------------------------------------------------|
| Strategy                 | Choosing a travel route (car, bike, walk)           |
| Observer                 | Email subscribers get new article notifications     |
| Command                  | TV remote control buttons                           |
| Chain of Responsibility  | Customer service escalation (agent → manager)       |
| State                    | Traffic light state transitions                    |
| Mediator                 | Air traffic controller coordinating planes          |
| Memento                  | Ctrl+Z in Word or Photoshop                        |
| Visitor                  | Tax calculator applied to different product types   |
| Iterator                 | Flipping through TV channels                        |
| Template Method          | Standardized cooking recipe with customizable steps |
| Interpreter              | Calculator parsing mathematical expressions        |
| Null Object              | Guest user with limited permissions instead of null |

---

## 🧠 Interview Tip Sheet

| Tip                                  | Why it Matters                                      |
|--------------------------------------|-----------------------------------------------------|
| Know the **core intent**             | Interviewers ask “when and why” to use a pattern    |
| Use **real-world analogies**         | Simplifies explanations for non-technical listeners |
| Identify **key participants**        | E.g., Context, Strategy, Command, Receiver, etc.    |
| Highlight **Open/Closed Principle**  | Many patterns support extensibility                 |
| Provide a **short code snippet**     | Shows practical understanding                      |

---

## 🧮 Strategy Pattern

### Intent
Encapsulates a family of algorithms, making them interchangeable at runtime, allowing behavior to vary independently of the client.

### When to Use
- Switch between algorithms dynamically (e.g., payment methods).
- Avoid conditional statements for behavior selection.
- Support multiple algorithm variants.

### Real-World Example
Choosing a travel route (car, bike, or public transport) based on time or cost.

### Structure
- **Context**: Delegates tasks to a Strategy object.
- **Strategy Interface**: Defines the algorithm interface.
- **Concrete Strategies**: Implement specific algorithms.

### Example Code (PHP)
```php
interface PaymentStrategy {
    public function pay(float $amount): bool;
}

class CreditCardStrategy implements PaymentStrategy {
    public function pay(float $amount): bool {
        echo "Paid \${$amount} using Credit Card.\n";
        return true;
    }
}

class PayPalStrategy implements PaymentStrategy {
    public function pay(float $amount): bool {
        echo "Paid \${$amount} using PayPal.\n";
        return true;
    }
}

class ShoppingCart {
    private ?PaymentStrategy $strategy = null;

    public function setPaymentStrategy(PaymentStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function checkout(float $amount) {
        if (!$this->strategy) throw new Exception("Strategy not set");
        return $this->strategy->pay($amount);
    }
}

// Usage
$cart = new ShoppingCart();
$cart->setPaymentStrategy(new CreditCardStrategy());
$cart->checkout(100.00); // Output: Paid $100 using Credit Card.
$cart->setPaymentStrategy(new PayPalStrategy());
$cart->checkout(50.00); // Output: Paid $50 using PayPal.
```

### Pros
- Supports **Open/Closed Principle**.
- Reduces conditionals.
- Enables runtime behavior swapping.

### Cons
- Clients must know all strategies.
- Increases class count.

---

## 🔁 Observer Pattern

### Intent
Defines a one-to-many dependency where a subject’s state change notifies all dependent observers automatically.

### When to Use
- Multiple objects react to state changes (e.g., UI updates).
- Need loose coupling between subject and observers.
- Propagate state changes to multiple components.

### Real-World Example
Blog subscribers get notified of new posts via email.

### Structure
- **Subject**: Manages observers and notifies them.
- **Observer Interface**: Defines the update method.
- **Concrete Observers**: Implement update logic.

### Example Code (PHP)
```php
interface Observer {
    public function update(string $message): void;
}

interface Subject {
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(): void;
}

class Blog implements Subject {
    private array $observers = [];
    private string $latestPost = '';

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        $this->observers = array_filter($this->observers, fn($o) => $o !== $observer);
    }

    public function notify(): void {
        foreach ($this->observers as $observer) {
            $observer->update($this->latestPost);
        }
    }

    public function publishPost(string $post): void {
        $this->latestPost = $post;
        $this->notify();
    }
}

class Subscriber implements Observer {
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function update(string $message): void {
        echo "{$this->name} received new post: $message\n";
    }
}

// Usage
$blog = new Blog();
$alice = new Subscriber("Alice");
$bob = new Subscriber("Bob");
$blog->attach($alice);
$blog->attach($bob);
$blog->publishPost("New AI Article!"); // Output: Alice received new post: New AI Article!
                                       //         Bob received new post: New AI Article!
$blog->detach($bob);
$blog->publishPost("ML Guide"); // Output: Alice received new post: ML Guide
```

### Pros
- Loose coupling.
- Dynamic observer management.
- Broadcast communication.

### Cons
- Memory leaks if observers aren’t detached.
- Notification overhead with many observers.

---

## 🧾 Command Pattern

### Intent
Encapsulates requests as objects, enabling parameterization, queuing, logging, or undoable operations.

### When to Use
- Decouple requester from performer.
- Support undo/redo, logging, or queuing.
- Parameterize objects with operations.

### Real-World Example
TV remote buttons trigger actions without knowing the TV’s internals.

### Structure
- **Command Interface**: Declares execute/undo methods.
- **Concrete Command**: Calls receiver’s action.
- **Receiver**: Performs the action.
- **Invoker**: Triggers command execution.

### Example Code (PHP)
```php
interface Command {
    public function execute(): void;
    public function undo(): void;
}

class Light {
    public function turnOn(): void {
        echo "Light is ON\n";
    }

    public function turnOff(): void {
        echo "Light is OFF\n";
    }
}

class LightOnCommand implements Command {
    private Light $light;

    public function __construct(Light $light) {
        $this->light = $light;
    }

    public function execute(): void {
        $this->light->turnOn();
    }

    public function undo(): void {
        $this->light->turnOff();
    }
}

class RemoteControl {
    private ?Command $command = null;

    public function setCommand(Command $command): void {
        $this->command = $command;
    }

    public function pressButton(): void {
        if ($this->command) $this->command->execute();
    }

    public function pressUndo(): void {
        if ($this->command) $this->command->undo();
    }
}

// Usage
$light = new Light();
$lightOn = new LightOnCommand($light);
$remote = new RemoteControl();
$remote->setCommand($lightOn);
$remote->pressButton(); // Output: Light is ON
$remote->pressUndo();   // Output: Light is OFF
```

### Pros
- Decouples invoker and receiver.
- Supports undo/redo and history.
- Enables queuing.

### Cons
- Increases class count.
- Complicates simple operations.

---

## 🧵 Chain of Responsibility Pattern

### Intent
Passes a request along a chain of handlers, each deciding to process or pass it to the next handler.

### When to Use
- Multiple objects might handle a request.
- Decouple sender from receiver.
- Process requests in a specific order.

### Real-World Example
Customer service escalation from agent to manager.

### Structure
- **Handler Interface**: Defines handling and chaining methods.
- **Concrete Handlers**: Process or pass requests.
- **Client**: Initiates the chain.

### Example Code (PHP)
```php
interface Handler {
    public function setNext(Handler $handler): Handler;
    public function handle(string $request): ?string;
}

abstract class AbstractHandler implements Handler {
    private ?Handler $nextHandler = null;

    public function setNext(Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $request): ?string {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return null;
    }
}

class LowPriorityHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if ($request === "low") {
            return "Handled by LowPriorityHandler";
        }
        return parent::handle($request);
    }
}

class HighPriorityHandler extends AbstractHandler {
    public function handle(string $request): ?string {
        if ($request === "high") {
            return "Handled by HighPriorityHandler";
        }
        return parent::handle($request);
    }
}

// Usage
$low = new LowPriorityHandler();
$high = new HighPriorityHandler();
$low->setNext($high);
echo $low->handle("low");  // Output: Handled by LowPriorityHandler
echo $low->handle("high"); // Output: Handled by HighPriorityHandler
```

### Pros
- Decouples sender and receiver.
- Flexible chain configuration.
- Single Responsibility Principle.

### Cons
- Request may go unhandled.
- Chain configuration can be complex.

---

## 🧯 State Pattern

### Intent
Allows an object to alter its behavior when its internal state changes, appearing as if it changes its class.

### When to Use
- Behavior depends on state.
- Avoid large conditional statements for state-based logic.
- Manage state transitions explicitly.

### Real-World Example
Traffic light switching between red, yellow, and green states.

### Structure
- **Context**: Maintains the current state.
- **State Interface**: Defines state-specific behavior.
- **Concrete States**: Implement behavior for each state.

### Example Code (PHP)
```php
interface TrafficLightState {
    public function handle(TrafficLight $light): void;
}

class RedState implements TrafficLightState {
    public function handle(TrafficLight $light): void {
        echo "Red: Stop\n";
        $light->setState(new GreenState());
    }
}

class GreenState implements TrafficLightState {
    public function handle(TrafficLight $light): void {
        echo "Green: Go\n";
        $light->setState(new YellowState());
    }
}

class YellowState implements TrafficLightState {
    public function handle(TrafficLight $light): void {
        echo "Yellow: Prepare to stop\n";
        $light->setState(new RedState());
    }
}

class TrafficLight {
    private TrafficLightState $state;

    public function __construct() {
        $this->state = new RedState();
    }

    public function setState(TrafficLightState $state): void {
        $this->state = $state;
    }

    public function change(): void {
        $this->state->handle($this);
    }
}

// Usage
$light = new TrafficLight();
$light->change(); // Output: Red: Stop
$light->change(); // Output: Green: Go
$light->change(); // Output: Yellow: Prepare to stop
```

### Pros
- Encapsulates state-specific behavior.
- Simplifies context logic.
- Supports Open/Closed Principle.

### Cons
- Increases class count.
- State transitions can be complex.

---

## 💬 Mediator Pattern

### Intent
Centralizes communication between objects to reduce direct coupling, promoting loose interactions.

### When to Use
- Objects have complex, interdependent communication.
- Reduce tight coupling between components.
- Centralize interaction logic.

### Real-World Example
Air traffic controller coordinating plane movements.

### Structure
- **Mediator Interface**: Defines communication methods.
- **Concrete Mediator**: Manages interactions.
- **Colleagues**: Communicate via the mediator.

### Example Code (PHP)
```php
interface ChatMediator {
    public function sendMessage(string $message, User $user): void;
}

class ChatRoom implements ChatMediator {
    public function sendMessage(string $message, User $user {
        echo "{$user->name} sends: $message\n";
    }
}

class User {
    private string $name;
    private ChatMediator $mediator;

    public function __construct(string $name, ChatMediator $mediator) {
        $this->name = $name;
        $this->mediator = $mediator;
    }

    public function send(string $message): void {
        $this->mediator->sendMessage($message, this$this);
    }
}

// Usage
$chatroom = new ChatRoom();
$alice = new User("Alice", $chatroom);
$bob = new User("Bob", $chatroom);
$alice->send("Hi Bob!"); // Output: Alice sends: Hi Bob!
$bob->send("Hello Alice!"); // Output: Bob sends: Hello Alice!
```

### Pros
- Reduces coupling between colleagues.
- Centralizes interaction logic.
- Simplifies maintenance.

### Cons
- Mediator can become complex.
- May introduce a single point of failure.

---

## ♻️ Memento Pattern

### Intent
Captures and restores an object’s state without violating encapsulation, enabling undo/redo.

### When to Use
- Implement undo functionality.
- Save and restore object states.
- Avoid exposing internal state.

### Real-World Example
Ctrl+Z in a text editor to revert changes.

### Structure
- **Originator**: Creates and restores mementos.
- **Memento**: Stores the state.
- **Caretaker**: Manages mementos.

### Example Code (PHP)
```php
class EditorMemento {
    private string $state;

    public function __construct(string $state) {
        $this->state = $state;
    }

    public function getState(): string {
        return $this->state;
    }
}

class TextEditor {
    private string $content = '';

    public function write(string $text): void {
        $this->content .= $text;
    }

    public function save(): EditorMemento {
        return new EditorMemento($this->content);
    }

    public function restore(EditorMemento $memento): void {
        $this->content = $memento->getState();
    }

    public function getContent(): string {
        return $this->content;
    }
}

class History {
    private array $mementos = [];

    public function push(EditorMemento $memento): void {
        $this->mementos[] = $memento;
    }

    public function pop(): ?EditorMemento {
        return array_pop($this->mementos);
    }
}

// Usage
$editor = new TextEditor();
$history = new History();
$editor->write("Hello");
$history->push($editor->save());
$editor->write(" World");
$history->push($editor->save());
echo $editor->getContent(); // Output: Hello World
$editor->restore($history->pop());
echo $editor->getContent(); // Output: Hello
```

### Pros
- Preserves encapsulation.
- Simplifies undo/redo.
- Supports state history.

### Cons
- Memory-intensive for large states.
- Increases complexity.

---

## 🕵️‍♂️ Visitor Pattern

### Intent
Separates operations from the object structure, allowing new operations without modifying classes.

### When to Use
- Add operations to a stable object hierarchy.
- Perform operations on different element types.
- Avoid modifying existing classes.

### Real-World Example
Tax calculator applied to different product types.

### Structure
- **Visitor Interface**: Declares visit methods for each element type.
- **Concrete Visitor**: Implements operations.
- **Elements**: Accept visitors and call their methods.

### Example Code (PHP)
```php
interface Visitor {
    public function visitBook(Book $book): void;
    public function visitElectronics(Electronics $electronics): void;
}

interface Element {
    public function accept(Visitor $visitor): void;
}

class Book implements Element {
    private float $price;

    public function __construct(float $price) {
        $this->price = $price;

    }

    public function getPrice(): float {
        return $this->price;

    }

    public function accept(Visitor $visitor): void {
        $visitor->visitBook($this);
    }
}

class Electronics implements Element {
    private float $price;

    public function __construct(float $price) {
        $this->price = $price;

    }

    public function getPrice(): float {
        return $this->price;
    }

    public function accept(Visitor $visitor): void {
        $visitor->visitElectronics($this);
    }
}

class TaxVisitor implements Visitor {
    public function visitBook(Book $book): void {
        $tax = $book->getPrice() * return 0.05;
        echo "Book tax: $tax\n";
    }

    public function visitElectronics(Electronics $electronics): void {
        $tax = $electronics->getPrice() * return 0.10;
        echo "Electronics tax: $tax\n";
    }
}

// Usage
$book = new Book(100.0);
$electronics = new Electronics(500.0);
$taxCalculator = new TaxVisitor();
$book->accept($taxCalculator); // Output: Book tax: $5
$electronics->accept($taxCalculator); // Output: Electronics tax: $50
```

### Pros
- Adds operations without modifying classes.
- Supports Open/Closed principle.
- Centralizes related operations.
- Centralizes Open/Closed Principle.

### Cons
- Requires updating visitors for new elements.
- Can break encapsulation if elements expose internals.

---

## 🚶 Iterator Pattern

### Intent
Provides sequential access to a collection’s elements without exposing its structure.

### When to Use
- Traverse collections uniformly.
- Hide collection implementation.
- Support multiple traversal algorithms.

### Real-World Example
Flipping through TV channels with a remote.

### Structure
- **Iterator Interface**: Defines traversal methods.
- **Concrete Iterator**: Implements traversal.
- **Collection**: Provides iterator access.

### Example Code (PHP)
```php
interface IteratorInterface {
    public function hasNext(): bool;
    public function next(): ?string;
}

interface Aggregate {
    public function createIterator(): IteratorInterface;
}

class BookCollection implements Aggregate {
    private array $books;

    public function __construct(array $books) {
        $this->books = $books;

    }

    public function createIterator(): IteratorInterface {
        return new BookIterator($this->books);
    }
}

class BookIterator implements IteratorInterface IteratorInterface {
    private array $books;
    private int $position = 0;

    public function __construct(array $books) implements {
        $this->books = $books;
    }

    public function hasBookNext(): bool {
        return $this->position < count($this->books);
    }

    public function next(): ?string {
        return $this->books[$this->position++];

    }
}

// Usage
$collection = new BookCollection(["Book1", "Book2", "Book3"]);
$iterator = $collection->createIterator();
while ($iterator->hasNext()) {
    echo $iterator->next() . "\n"; // Output: Book1 Book2 Book3
}
```

### Pros
}
```

### Cons
- May be overkill for simple collections.
- Adds complexity for basic traversals.

---

## 🛠️ Template Method Pattern

### Intent
Defines an algorithm’s skeleton, allowing subclasses to override specific steps without changing the structure.

### When to Use
- Share common algorithm logic.
- Allow subclasses to customize steps.
- Enforce a consistent process.

### Real-World Example
A recipe with fixed steps but customizable ingredients.

### Structure
- **Abstract Class**: Defines the template method and abstract steps.
- **Concrete Classes**: Implement specific steps.

### Example Code (PHP)
```php
abstract class Beverage {
    public final function template prepare(): void {
        $this->boilWater();
        $this->brew();
        $this->pour();
        $this->addCondiments();
    }

    protected function boilWater(): void {
        echo "Boiling water\n";
    }

    protected abstract function void brew();
    protected abstract function void addCondiments();
    protected void function pour(): void {
        echo "Pouring into cup\n";
    }

class Coffee extends Beverage {
    protected function brew(): void {
        echo "Brewing coffee\n";
    }

    protected function addCondiments(): void {
        echo "Adding sugar\n";
    }
}

class Tea extends Beverage {
    protected function brew(): void {
        echo "Brewing tea\n";
    }

    protected function addCondiments(): void {
        echo "Adding lemon\n";
    }
}

// Usage
$coffee = new Coffee();
$coffee->prepare(); // Output: Boiling water
                    //         Brewing coffee
                    //         Pouring into cup
                    //         Adding sugar
$tea = new Tea();
$tea->prepare(); // Output: Boiling water
                //         Brewing tea
                //         Pouring into cup
                //         Adding lemon
```

### Pros
- Reuses common logic.
- Enforces algorithm structure.
- Simplifies subclassing.

### Cons
- Restricts flexibility in algorithm changes.
- May lead to many subclasses.

---

## 🗣️ Interpreter Pattern

### Intent
Defines a grammar and interpreter for a language to evaluate expressions.

### When to Use
- Interpret simple languages or expressions.
- Implement rule engines or query processors.
- Handle custom syntax.

### Real-World Example
A calculator parsing mathematical expressions.

### Structure
- **Expression Interface**: Defines the interpret method.
- **Concrete Expressions**: Implement interpretation logic.
- **Context**: Holds interpretation data.

### Example Code (PHP)
```php
interface Expression {
    public function interpret(array $context): bool;
}

class VariableExpression implements Expression {
    private string $variable;

    public function __construct(string $variable) {
        $this->variable = $variable;

    }

    public function interpret(array $context): bool {
        return $context[$this->variable] ?? false;
    }
}

class AndExpression implements Expression {
    private Expression $left;
    private Expression $right;

    public function __construct(Expression $left, Expression $right) {
        $this->left = $left;
        $this->right = $right;

    }

    public function interpret(array $context): bool {
        return $this->left->interpret($context) && $this->right->interpret($context);
    }
}

// Usage
$context = ["x" => true, "y" => false];
$x = new VariableExpression("x");
$y = new VariableExpression("y");
$expression = new AndExpression($x, $y);
echo $expression->interpret($context) ? "True" : "False"; // Output: False
```

### Pros
- Easy to extend grammar.
- Supports custom languages.
- Flexible for rule-based systems.

### Cons
- Complex for large grammars.
- Performance overhead for parsing.

---

## 🚫 Null Object Pattern

### Intent
Provides a neutral object to replace null, avoiding null checks.

### When to Use
- Avoid null references.
- Provide default behavior for absent objects.
- Simplify client code.

### Real-World Example
A guest user with limited permissions instead of a null user.

### Structure
- **Abstract Class/Interface**: Defines the behavior.
- **Real Object**: Implements actual behavior.
- **Null Object**: Implements neutral behavior.

### Example Code (PHP)
```php
interface Logger {
    public function log(string $message): void;
}

class FileLogger implements Logger {
    public function log(string $message): void {
        echo "Logging to file: $message\n";
    }
}

class NullLogger implements Logger {
    public function log(string $message): void {
        // Do nothing
    }
}

class Application {
    private Logger $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function doSomething(): void {
        $this->logger->log("Action performed");
    }
}

// Usage
$appWithLogger = new Application(new FileLogger());
$appWithLogger->doSomething(); // Output: Logging to file: Action performed
$appWithoutLogger = new Application(new NullLogger());
$appWithoutLogger->doSomething(); // Output: (nothing)
```

### Pros
- Eliminates null checks.
- Simplifies client code.
- Provides safe default behavior.

### Cons
- Adds extra classes.
- May hide bugs if null is unexpected.

---

## 🧠 Interview Tips for All Patterns

- **Compare Patterns**: Know differences (e.g., Strategy vs. State, Observer vs. Mediator).
- **Use Cases**: Tie patterns to real-world applications (e.g., Strategy for payment systems, Command for undo).
- **Code Snippets**: Be ready to write simple implementations.
- **Trade-Offs**: Discuss pros/cons to show critical thinking.
- **Principles**: Highlight SOLID principles (e.g., Open/Closed, Single Responsibility).