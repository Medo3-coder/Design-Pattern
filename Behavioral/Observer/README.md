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

Here's a PHP implementation of the Observer pattern for a simple weather station:

```php
<?php

// Observer interface
interface Observer {
    public function update(array $data);
}

// Subject (Observable) class
class Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        if (!in_array($observer, $this->observers, true)) {
            $this->observers[] = $observer;
            echo "Attached observer: " . get_class($observer) . "\n";
        }
    }

    public function detach(Observer $observer) {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
            // Reindex array to avoid gaps
            $this->observers = array_values($this->observers);
            echo "Detached observer: " . get_class($observer) . "\n";
        }
    }

    public function notify(array $data) {
        echo "Subject is notifying " . count($this->observers) . " observers...\n";
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}

// Concrete Subject
class WeatherStation extends Subject {
    private $temperature;
    private $humidity;
    private $pressure;

    public function __construct() {
        $this->temperature = 0;
        $this->humidity = 0;
        $this->pressure = 0;
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure) {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;

        echo "\nWeather Station measurements updated:\n";
        echo "Temperature: $temperature°C\n";
        echo "Humidity: $humidity%\n";
        echo "Pressure: $pressure hPa\n";

        // Notify all observers about the change
        $this->notify([
            'temperature' => $this->temperature,
            'humidity' => $this->humidity,
            'pressure' => $this->pressure
        ]);
    }

    // Getter methods for observers to access current state
    public function getTemperature(): float {
        return $this->temperature;
    }

    public function getHumidity(): float {
        return $this->humidity;
    }

    public function getPressure(): float {
        return $this->pressure;
    }
}

// Concrete Observer 1
class CurrentConditionsDisplay implements Observer {
    public function update(array $data) {
        $temperature = $data['temperature'];
        $humidity = $data['humidity'];
        $message = "Current conditions: {$temperature}°C and {$humidity}% humidity";
        echo "CurrentConditionsDisplay updated: $message\n";
    }
}

// Concrete Observer 2
class StatisticsDisplay implements Observer {
    private $temperatures = [];

    public function update(array $data) {
        $temperature = $data['temperature'];
        $this->temperatures[] = $temperature;

        $avg = array_sum($this->temperatures) / count($this->temperatures);
        $max = max($this->temperatures);
        $min = min($this->temperatures);

        $message = sprintf("Avg/Max/Min temperature = %.1f/%.1f/%.1f", $avg, $max, $min);
        echo "StatisticsDisplay updated: $message\n";
    }
}

// Concrete Observer 3
class ForecastDisplay implements Observer {
    private $lastPressure = 0;
    private $currentPressure = 0;

    public function update(array $data) {
        $this->lastPressure = $this->currentPressure;
        $this->currentPressure = $data['pressure'];

        $forecast = "";
        if ($this->currentPressure > $this->lastPressure) {
            $forecast = "Improving weather on the way!";
        } elseif ($this->currentPressure === $this->lastPressure) {
            $forecast = "More of the same";
        } else {
            $forecast = "Watch out for cooler, rainy weather";
        }

        $message = "Forecast: $forecast";
        echo "ForecastDisplay updated: $message\n";
    }
}

// Using the pattern
echo "Weather Station initialized\n";

$weatherStation = new WeatherStation();

$currentDisplay = new CurrentConditionsDisplay();
$statisticsDisplay = new StatisticsDisplay();
$forecastDisplay = new ForecastDisplay();

$weatherStation->attach($currentDisplay);
$weatherStation->attach($statisticsDisplay);
$weatherStation->attach($forecastDisplay);

// Simulate weather changes
$weatherStation->setMeasurements(22, 65, 1012);
$weatherStation->setMeasurements(24, 70, 1010);
$weatherStation->setMeasurements(20, 90, 1005);

// Example of detaching an observer
$weatherStation->detach($forecastDisplay);
echo "\nAfter detaching ForecastDisplay:\n";
$weatherStation->setMeasurements(23, 75, 1008);

?>
```


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


## Notes on the PHP Implementation

- **Structure:** The PHP code mirrors the JavaScript example's structure:
  - `Observer` interface defines the `update` method.
  - `Subject` class manages a list of observers with `attach`, `detach`, and `notify` methods.
  - `WeatherStation` extends `Subject` and maintains weather data (temperature, humidity, pressure).
  - Three concrete observers (`CurrentConditionsDisplay`, `StatisticsDisplay`, `ForecastDisplay`) implement the `Observer` interface.
- **Console Output:** Instead of updating DOM elements, the PHP version outputs to the console using `echo`, making it suitable for CLI execution.
- **Type Safety:** PHP's type declarations (e.g., `float`, `array`) are used where applicable to ensure clarity and robustness.
- **No Interactive Demo:** The interactive demo from the HTML (sliders, toggles, etc.) relies on browser-based DOM manipulation, which isn't feasible in PHP without a web framework. The core logic is preserved, and you can run this script in a PHP environment (e.g., `php script.php`) to see the output.
- **SVG Visualization:** The SVG diagram from the HTML is not included in the PHP code, as it’s a visual aid not executable in PHP. It’s referenced in the original Markdown content and can be reused if needed.
- **Usage Example:** The script includes the same weather measurement updates as the JavaScript example (22°C/65%/1012hPa, 24°C/70%/1010hPa, 20°C/90%/1005hPa) and adds a detachment example to demonstrate dynamic observer management.

### Running the Code
Save the code in a file (e.g., `observer.php`) and run it in a terminal with:
```bash
php observer.php
```

### Expected Output
The output will look something like this:
```
Weather Station initialized
Attached observer: CurrentConditionsDisplay
Attached observer: StatisticsDisplay
Attached observer: ForecastDisplay

Weather Station measurements updated:
Temperature: 22°C
Humidity: 65%
Pressure: 1012 hPa
Subject is notifying 3 observers...
CurrentConditionsDisplay updated: Current conditions: 22°C and 65% humidity
StatisticsDisplay updated: Avg/Max/Min temperature = 22.0/22.0/22.0
ForecastDisplay updated: Forecast: More of the same

Weather Station measurements updated:
Temperature: 24°C
Humidity: 70%
Pressure: 1010 hPa
Subject is notifying 3 observers...
CurrentConditionsDisplay updated: Current conditions: 24°C and 70% humidity
StatisticsDisplay updated: Avg/Max/Min temperature = 23.0/24.0/22.0
ForecastDisplay updated: Forecast: Watch out for cooler, rainy weather

Weather Station measurements updated:
Temperature: 20°C
Humidity: 90%
Pressure: 1005 hPa
Subject is notifying 3 observers...
CurrentConditionsDisplay updated: Current conditions: 20°C and 90% humidity
StatisticsDisplay updated: Avg/Max/Min temperature = 22.0/24.0/20.0
ForecastDisplay updated: Forecast: Watch out for cooler, rainy weather

Detached observer: ForecastDisplay

After detaching ForecastDisplay:
Weather Station measurements updated:
Temperature: 23°C
Humidity: 75%
Pressure: 1008 hPa
Subject is notifying 2 observers...
CurrentConditionsDisplay updated: Current conditions: 23°C and 75% humidity
StatisticsDisplay updated: Avg/Max/Min temperature = 22.3/24.0/20.0
```

### Additional Notes
- **No External Images:** The original HTML had no external images, only an inline SVG for the visualization, which is preserved in the Markdown content from the previous response.
- **CSS/JavaScript Omitted:** The CSS and JavaScript for the interactive demo are not included in the PHP version, as they are browser-specific. If you want a web-based PHP version with a similar interactive interface, you’d need a PHP web framework (e.g., Laravel) and additional front-end code, which I can help with if requested.
- **Extensibility:** The PHP code is modular and can be extended with additional observers or subjects as needed.

If you need a web-based version, want to include the SVG visualization in a different way, or have other modifications in mind, let me know!
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
