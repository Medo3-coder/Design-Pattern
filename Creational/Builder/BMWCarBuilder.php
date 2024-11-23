<?php

use Creational\Builder\CarBuilderInterface;
use Creational\Builder\Models\BMWCar;
use Creational\Builder\Models\Car;

class BMWCarBuilder implements CarBuilderInterface {
    /**
     *
     * @var Car $type
     *
     */

    private $type;

    public function createCar() {
        $this->type = new BMWCar();
    }

    public function addBody() {
        $this->type->setPart('BODY', 'BM-body');
    }

    public function addDoors() {
        $this->type->setPart('DOOR', 'BM-door');
    }
    public function addEngine() {
        $this->type->setPart('ENGINE', 'BM-engine');
    }
    public function addWheel() {
        $this->type->setPart('WHEEL', 'BM-wheel');
    }

    public function getCar(): Car {
        return $this->type;
    }
}