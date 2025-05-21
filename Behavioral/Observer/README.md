# Observer Pattern

> Define a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically.

## Understanding the Observer Pattern

The Observer pattern is a behavioral design pattern that establishes a one-to-many relationship between objects. When one object (the subject) changes state, all its dependents (observers) are notified and updated automatically. This pattern is a cornerstone of event-driven programming.

### Problem

Imagine you're developing an application where changes to one object require actions in other objects. For example, when a stock price changes, multiple displays need to update: a price chart, a list view, and a statistics panel. Without a proper pattern, you might end up with tight coupling between these components, making your code rigid and difficult to maintain.

The challenge is to establish communication between these objects while keeping them loosely coupled. You want the price object to notify the displays of changes without knowing which displays are listening.

### Solution

The Observer pattern suggests defining a one-to-many dependency between objects. The key objects in this pattern are the Subject (also called Observable) and Observer:

- **Subject:** Maintains a list of observers and provides methods to add, remove, and notify observers.
- **Observer:** Defines an interface for objects that should be notified of changes in a subject.

When the subject's state changes, it notifies all observers. The observers can then query the subject to get the updated state and take appropriate actions.

### Participants

- **Subject (Observable):** Knows its observers and provides interfaces for attaching, detaching, and notifying observers.
- **ConcreteSubject:** Stores state of interest to ConcreteObserver objects and sends notifications when its state changes.
- **Observer:** Defines an updating interface for objects that should be notified of changes in a subject.
- **ConcreteObserver:** Implements the Observer updating interface to keep its state consistent with the subject's.

### When to Use

Use the Observer Pattern when:

- When an abstraction has two aspects, one dependent on the other.
- When a change to one object requires changing others, and you don't know how many objects need to be changed.
- When an object should be able to notify other objects without making assumptions about who these objects are.
- When you need to maintain consistency between related objects without making them tightly coupled.

### Benefits

- **Loose Coupling:** Subjects and observers can interact without knowing much about each other.
- **Support for Broadcast Communication:** Notifications are broadcast automatically to all interested objects.
- **Dynamic Relationships:** Observers can be added and removed at runtime.
- **Open/Closed Principle:** You can introduce new subscriber classes without changing the publisher's code.

### Real-World Uses

- **GUI Components:** When UI elements need to update in response to data changes.
- **Event Handling Systems:** In web browsers, DOM events use the Observer pattern.
- **Message Brokers:** Publish-subscribe messaging patterns in distributed systems.
- **Data Binding:** In MVC/MVVM frameworks to synchronize models and views.
- **Social Media:** Notification systems where users subscribe to updates.

## Implementation Example

Here's a JavaScript implementation of the Observer pattern for a simple weather station:

```javascript
// Observer interface
class Observer {
    update(data) {
        throw new Error("Method 'update()' must be implemented");
    }
}

// Subject (Observable)
class Subject {
    constructor() {
        this.observers = [];
    }
    
    attach(observer) {
        if (observer instanceof Observer && !this.observers.includes(observer)) {
            this.observers.push(observer);
        }
    }
    
    detach(observer) {
        const index = this.observers.indexOf(observer);
        if (index !== -1) {
            this.observers.splice(index, 1);
        }
    }
    
    notify(data) {
        for (const observer of this.observers) {
            observer.update(data);
        }
    }
}

// Concrete Subject
class WeatherStation extends Subject {
    constructor() {
        super();
        this.temperature = 0;
        this.humidity = 0;
        this.pressure = 0;
    }

    setMeasurements(temperature, humidity, pressure) {
        this.temperature = temperature;
        this.humidity = humidity;
        this.pressure = pressure;

        // Notify all observers about the change
        this.notify({
            temperature: this.temperature,
            humidity: this.humidity,
            pressure: this.pressure
        });
    }
}

// Concrete Observer 1
class CurrentConditionsDisplay extends Observer {
    constructor() {
        super();
    }

    update(data) {
        const { temperature, humidity } = data;
        console.log(`Current conditions: ${temperature}°C and ${humidity}% humidity`);
    }
}

// Concrete Observer 2
class StatisticsDisplay extends Observer {
    constructor() {
        super();
        this.temperatures = [];
    }

    update(data) {
        const { temperature } = data;
        this.temperatures.push(temperature);
        
        const avg = this.temperatures.reduce((sum, t) => sum + t, 0) / this.temperatures.length;
        const max = Math.max(...this.temperatures);
        const min = Math.min(...this.temperatures);
        
        console.log(`Avg/Max/Min temperature = ${avg.toFixed(1)}/${max}/${min}`);
    }
}

// Concrete Observer 3
class ForecastDisplay extends Observer {
    constructor() {
        super();
        this.lastPressure = 0;
        this.currentPressure = 0;
    }

    update(data) {
        const { pressure } = data;
        this.lastPressure = this.currentPressure;
        this.currentPressure = pressure;
        
        let forecast = "";
        if (this.currentPressure > this.lastPressure) {
            forecast = "Improving weather on the way!";
        } else if (this.currentPressure === this.lastPressure) {
            forecast = "More of the same";
        } else {
            forecast = "Watch out for cooler, rainy weather";
        }
        
        console.log(`Forecast: ${forecast}`);
    }
}

// Using the pattern
const weatherStation = new WeatherStation();

const currentDisplay = new CurrentConditionsDisplay();
const statisticsDisplay = new StatisticsDisplay();
const forecastDisplay = new ForecastDisplay();

weatherStation.attach(currentDisplay);
weatherStation.attach(statisticsDisplay);
weatherStation.attach(forecastDisplay);

// Simulate weather changes
weatherStation.setMeasurements(22, 65, 1012);
weatherStation.setMeasurements(24, 70, 1010);
weatherStation.setMeasurements(20, 90, 1005);
```

In this example, the `WeatherStation` is our subject, and the various displays are the observers. When the weather data changes, all registered displays are automatically updated to show the new information. This demonstrates how the Observer pattern can be used to implement a loose coupling between related objects.

## Interactive Demo

The original HTML includes an interactive demo of a weather station, allowing users to adjust temperature, humidity, and pressure to see how observers update. Below is the JavaScript code that powers the interactive demo, included for reference:

```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Observer interface
    class Observer {
        update(data) {
            throw new Error("Method 'update()' must be implemented");
        }
    }

    // Subject (Observable)
    class Subject {
        constructor() {
            this.observers = [];
        }
        
        attach(observer) {
            if (observer instanceof Observer && !this.observers.includes(observer)) {
                this.observers.push(observer);
                logEvent(`Attached observer: ${observer.constructor.name}`);
            }
        }
        
        detach(observer) {
            const index = this.observers.indexOf(observer);
            if (index !== -1) {
                this.observers.splice(index, 1);
                logEvent(`Detached observer: ${observer.constructor.name}`);
            }
        }
        
        notify(data) {
            logEvent(`Subject is notifying ${this.observers.length} observers...`);
            for (const observer of this.observers) {
                observer.update(data);
            }
        }
    }

    // Concrete Subject
    class WeatherStation extends Subject {
        constructor() {
            super();
            this.temperature = 22;
            this.humidity = 65;
            this.pressure = 1012;
        }

        getTemperature() {
            return this.temperature;
        }

        getHumidity() {
            return this.humidity;
        }

        getPressure() {
            return this.pressure;
        }

        setMeasurements(temperature, humidity, pressure) {
            logEvent(`\nWeather Station measurements updated:
Temperature: ${temperature}°C
Humidity: ${humidity}%
Pressure: ${pressure} hPa`);
            
            this.temperature = temperature;
            this.humidity = humidity;
            this.pressure = pressure;

            // Notify all observers about the change
            this.notify({
                temperature: this.temperature,
                humidity: this.humidity,
                pressure: this.pressure
            });
        }
    }

    // Concrete Observer 1
    class CurrentConditionsDisplay extends Observer {
        constructor(element) {
            super();
            this.element = element;
            this.element.innerHTML = "Waiting for data...";
        }

        update(data) {
            const { temperature, humidity } = data;
            const message = `Current conditions: ${temperature}°C and ${humidity}% humidity`;
            logEvent(`CurrentConditionsDisplay updated: ${message}`);
            this.element.innerHTML = `
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="font-size: 2rem; color: var(--primary-color);">
                        ${temperature >= 25 ? '☀️' : temperature <= 10 ? '❄️' : '🌤️'}
                    </div>
                    <div>
                        <div style="font-size: 1.2rem; font-weight: 500;">${temperature}°C</div>
                        <div style="color: var(--text-muted);">${humidity}% humidity</div>
                    </div>
                </div>
            `;
        }
    }

    // Concrete Observer 2
    class StatisticsDisplay extends Observer {
        constructor(element) {
            super();
            this.element = element;
            this.temperatures = [];
            this.element.innerHTML = "Collecting data...";
        }

        update(data) {
            const { temperature } = data;
            this.temperatures.push(temperature);
            
            const avg = this.temperatures.reduce((sum, t) => sum + t, 0) / this.temperatures.length;
            const max = Math.max(...this.temperatures);
            const min = Math.min(...this.temperatures);
            
            const message = `Avg/Max/Min temperature = ${avg.toFixed(1)}°C/${max}°C/${min}°C`;
            logEvent(`StatisticsDisplay updated: ${message}`);
            
            this.element.innerHTML = `
                <div>
                    <div style="margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">Min:</span> 
                        <span style="font-weight: 500;">${min}°C</span>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">Avg:</span> 
                        <span style="font-weight: 500;">${avg.toFixed(1)}°C</span>
                    </div>
                    <div>
                        <span style="color: var(--text-muted);">Max:</span> 
                        <span style="font-weight: 500;">${max}°C</span>
                    </div>
                </div>
            `;
        }
    }

    // Concrete Observer 3
    class ForecastDisplay extends Observer {
        constructor(element) {
            super();
            this.element = element;
            this.lastPressure = 1012;
            this.currentPressure = 1012;
            this.element.innerHTML = "Waiting for data...";
        }

        update(data) {
            const { pressure } = data;
            this.lastPressure = this.currentPressure;
            this.currentPressure = pressure;
            
            let forecast = "";
            let icon = "";
            
            if (this.currentPressure > this.lastPressure) {
                forecast = "Improving weather on the way!";
                icon = "☀️";
            } else if (this.currentPressure === this.lastPressure) {
                forecast = "More of the same";
                icon = "🌤️";
            } else {
                forecast = "Watch out for cooler, rainy weather";
                icon = "🌧️";
            }
            
            const message = `Forecast: ${forecast}`;
            logEvent(`ForecastDisplay updated: ${message}`);
            
            this.element.innerHTML = `
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="font-size: 2rem;">${icon}</div>
                    <div>
                        <div style="font-weight: 500;">${forecast}</div>
                        <div style="color: var(--text-muted);">
                            Pressure: ${this.currentPressure} hPa 
                            ${this.currentPressure > this.lastPressure ? '↑' : this.currentPressure < this.lastPressure ? '↓' : '→'}
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // DOM elements and event listeners
    // ... (The rest of the JavaScript code handles DOM interactions and is not fully included here for brevity)
});

// Note: The interactive demo requires a web browser to run, as it involves DOM manipulation and user interactions.
```

**Note:** The interactive demo is not fully reproducible in Markdown due to its reliance on HTML, CSS, and JavaScript for interactivity. To experience the demo, you would need to run the original HTML file in a web browser.

## Footer

© 2025 Design Patterns Interactive Guide