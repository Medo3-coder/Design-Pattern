# Command Pattern

Turn a request into a stand-alone object that contains all information about the request.

## Understanding the Command Pattern

The Command pattern is a behavioral design pattern that turns a request into a stand-alone object that contains all information about the request. This transformation allows you to parameterize methods with different requests, delay or queue a request's execution, and support undoable operations.

### Problem

Imagine you're working on a text editor application. You need to implement various operations like copy, paste, undo, etc. You could create a complex class with numerous methods to handle all these operations, but this would violate the Single Responsibility Principle and make your code hard to maintain.

Additionally, consider a UI application where buttons trigger different actions depending on the context. How can you connect these buttons to various operations without creating dependencies on specific functionality?

### Solution

The Command pattern suggests encapsulating the request as an object. The key objects in this pattern include:

- **Command**: Declares an interface for executing an operation.
- **Concrete Command**: Defines a binding between a Receiver object and an action.
- **Invoker**: Asks the command to carry out the request.
- **Receiver**: Knows how to perform the operations associated with carrying out a request.
- **Client**: Creates a ConcreteCommand object and sets its receiver.

## Structure

![Command Pattern Structure](command_pattern_structure.png)

### Participants

- **Command**: Declares an interface for executing an operation, typically defining an `execute()` method and optionally an `undo()` method.
- **Concrete Command**: Implements the Command interface, invoking operations on the Receiver.
- **Invoker**: Holds a command and can trigger the execution of the command at some point.
- **Receiver**: The object that performs the actual work when a command's `execute()` method is called.
- **Client**: Creates and configures specific Command objects.

## When to Use

Use the Command Pattern when:

- You want to parameterize objects with operations.
- You want to queue operations, schedule their execution, or execute them remotely.
- You need to implement reversible operations with undo/redo functionality.
- You want to structure a system around high-level operations built on primitive operations.
- You need to decouple objects that invoke operations from objects that perform these operations.

## Benefits

- **Single Responsibility Principle**: You can decouple classes that invoke operations from classes that perform them.
- **Open/Closed Principle**: You can introduce new commands without changing existing code.
- **Undo/Redo**: Makes it easier to implement undo/redo operations.
- **Delayed Execution**: Commands can be serialized and executed later or even on a different thread.
- **Composite Commands**: You can assemble complex commands from simple ones using the Composite pattern.

## Real-World Uses

- **GUI Buttons and Menu Items**: Each button/menu item is associated with a command.
- **Transactional Systems**: Banking operations are often implemented as commands that can be rolled back.
- **Multi-level Undo-Redo**: Document editors track commands to allow undoing and redoing changes.
- **Task Scheduling**: Commands can be placed in a queue and executed asynchronously.
- **Remote Procedure Calls (RPC)**: Commands are serialized and sent to other systems for execution.

## Implementation Example

Here's a JavaScript implementation of the Command pattern for a simple text editor:

```javascript
// Command interface
class Command {
    execute() {
        throw new Error("Method 'execute()' must be implemented");
    }
    
    undo() {
        throw new Error("Method 'undo()' must be implemented");
    }
}

// Receiver
class TextEditor {
    constructor() {
        this.text = "";
    }
    
    insertText(text, position) {
        const before = this.text.substring(0, position);
        const after = this.text.substring(position);
        this.text = before + text + after;
        console.log(`Inserted "${text}" at position ${position}`);
        console.log(`Current text: "${this.text}"`);
    }
    
    deleteText(startPosition, endPosition) {
        const deletedText = this.text.substring(startPosition, endPosition);
        const before = this.text.substring(0, startPosition);
        const after = this.text.substring(endPosition);
        this.text = before + after;
        console.log(`Deleted "${deletedText}" from position ${startPosition} to ${endPosition}`);
        console.log(`Current text: "${this.text}"`);
        return deletedText;
    }
    
    getText() {
        return this.text;
    }
}

// Concrete Commands
class InsertTextCommand extends Command {
    constructor(textEditor, text, position) {
        super();
        this.textEditor = textEditor;
        this.text = text;
        this.position = position;
    }
    
    execute() {
        this.textEditor.insertText(this.text, this.position);
    }
    
    undo() {
        this.textEditor.deleteText(this.position, this.position + this.text.length);
    }
}

class DeleteTextCommand extends Command {
    constructor(textEditor, startPosition, endPosition) {
        super();
        this.textEditor = textEditor;
        this.startPosition = startPosition;
        this.endPosition = endPosition;
        this.deletedText = null;
    }
    
    execute() {
        this.deletedText = this.textEditor.deleteText(this.startPosition, this.endPosition);
    }
    
    undo() {
        if (this.deletedText !== null) {
            this.textEditor.insertText(this.deletedText, this.startPosition);
        }
    }
}

// Invoker
class CommandHistory {
    constructor() {
        this.history = [];
        this.undoneCommands = [];
    }
    
    executeCommand(command) {
        command.execute();
        this.history.push(command);
        // Clear redo stack when a new command is executed
        this.undoneCommands = [];
    }
    
    undo() {
        if (this.history.length > 0) {
            const command = this.history.pop();
            command.undo();
            this.undoneCommands.push(command);
        } else {
            console.log("Nothing to undo");
        }
    }
    
    redo() {
        if (this.undoneCommands.length > 0) {
            const command = this.undoneCommands.pop();
            command.execute();
            this.history.push(command);
        } else {
            console.log("Nothing to redo");
        }
    }
}

// Usage
const textEditor = new TextEditor();
const history = new CommandHistory();

// Execute commands
history.executeCommand(new InsertTextCommand(textEditor, "Hello", 0));
history.executeCommand(new InsertTextCommand(textEditor, " World", 5));
history.executeCommand(new DeleteTextCommand(textEditor, 5, 11));
history.executeCommand(new InsertTextCommand(textEditor, " JavaScript", 5));

// Undo and redo
history.undo(); // Undo the last InsertTextCommand
history.undo(); // Undo the DeleteTextCommand
history.redo(); // Redo the DeleteTextCommand
```

In this example, we've implemented a simple text editor with insert and delete functionality. The Command pattern allows us to execute these operations and also provides undo/redo capability by tracking the history of executed commands.

## Interactive Demo

Experience the Command pattern in action with this interactive text editor demo. You can type text, delete selections, and undo/redo your actions. Each operation is encapsulated as a Command object.

**Interactive Demo: Text Editor with Undo/Redo**

Type in the text area below and use the buttons to manipulate the text. Notice how each action creates a command object that can be undone or redone.

- Text to insert
- Insert Text
- Delete Selected
- Undo
- Redo

**Command History:**
```
// Command history will be displayed here
[11:50:36 AM] Text editor initialized. Start typing or use the buttons to create commands.
```

© 2025 Design Patterns Interactive Guide