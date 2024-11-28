<?php

use Creational\Builder\BENZCarBuilder;
use Creational\Builder\BMWCarBuilder;
use Creational\Builder\CarProducer;
use Creational\Builder\Models\BenzCar;
use Creational\Builder\Models\BMWCar;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase {
    public function testProduceBMWCar() {
        $BMWBuilder  = new BMWCarBuilder();
        $carProducer = new CarProducer($BMWBuilder);
        $myCar       = $carProducer->ProduceCar();
        $this->assertInstanceOf(BMWCar::class, $myCar);
    }

    public function testProduceBENZCar() {
        $Builder     = new BENZCarBuilder();
        $carProducer = new CarProducer($Builder);
        $myCar       = $carProducer->ProduceCar();
        $this->assertInstanceOf(BenzCar::class, $myCar);

    }
}