<?php

namespace Creational\ObjectPool\CarSystem;

class CarPool {

    private $freeCars = [];

    private $busyCars = [];

    /**
     * Rents a car from the pool.
     * If there are no free cars, creates a new one.
     *
     * @return Car The rented Car object.
     */

    public function rentCar() {
        if (count($this->freeCars) == 0) {
            // Create a new car if no free cars are available
            $car = new Car();
        } else {
            // Reuse an available car
            $car = array_pop($this->freeCars);
        }
        // Mark the car as busy using its unique hash ID
        $this->busyCars[spl_object_hash($car)] = $car;

        return $car;
    }

    /**
     * Frees a car by returning it to the pool of available cars.
     *
     * @param Car $car The Car object to free.
     * @return void
     */

    public function freeCar(Car $car) {

        $carId = spl_object_hash($car);

        // Move the car from busy to free if it exists in the busy list
        if (isset($this->busyCars[$carId])) {
            unset($this->busyCars[$carId]);
            $this->freeCars[$carId] = $car;
        }
    }

    /**
     * Gets the total number of cars in the pool (free + busy).
     *
     * @return int The total number of cars.
     */

    public function getReport() {
        return count($this->freeCars) + count($this->busyCars);
    }

    /**
     * Gets the number of free (available) cars in the pool.
     *
     * @return int The number of free cars.
     */

    public function getFreeCount() {
        return count($this->freeCars);
    }

}