<?php

namespace Creational\ObjectPool\CarSystem;

class Car {
    private $rentAt;

    public function __construct() {
        $this->rentAt = new \DateTime();
    }

    public function moveCar() {
        return "car is moving ";
    }
}
