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