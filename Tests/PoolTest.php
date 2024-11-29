<?php

namespace CreationalTests;

use Creational\ObjectPool\CarSystem\Car;
use Creational\ObjectPool\CarSystem\CarPool;
use PHPUnit\Framework\TestCase;

class PoolTest extends TestCase {
    private $carPool;
    protected function setUp(): void {
        $this->carPool = new CarPool();
    }

    public function testCanRentCar() {
        $myCar = $this->carPool->rentCar();

        $this->assertInstanceOf(Car::class, $myCar);
        $this->assertEquals(1, $this->carPool->getReport());
    }

    public function testCanFreeCar() {
        $myCar  = $this->carPool->rentCar();
        $myCar2 = $this->carPool->rentCar(); // busy car
        $this->assertEquals(0, $this->carPool->getFreeCount());
        $this->carPool->freeCar($myCar); // free car
        $this->assertEquals(2, $this->carPool->getReport());
        $this->assertEquals(1, $this->carPool->getFreeCount());

    }

}