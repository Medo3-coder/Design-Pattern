<?php 

namespace CreationalTests;

use Creational\ProtoType\CarSystem\AutomaticCarProtoType;
use Creational\ProtoType\CarSystem\ManualCarProtoType;
use Creational\Prototype\graphicsEditor\Shape;
use PHPUnit\Framework\TestCase;

class ProtoTypeTest extends TestCase 
{

    protected $circlePrototype;

    protected function setUp(): void {
        $this->circlePrototype = new Shape("Circle", "Red", "0,0");
    }

    // editor tests
    public function testCloneCreatesNewInstance(){
        $circle1 = $this->circlePrototype->clone();
        $circle2 = $this->circlePrototype->clone();

        $this->assertNotSame($this->circlePrototype, $circle1);
        $this->assertNotSame($circle1, $circle2);
    }

    public function testCloneRetainsOriginalProperties() {
        $clonedCircle = $this->circlePrototype->clone();

        $this->assertEquals("Circle", $clonedCircle->getType());
        $this->assertEquals("Red", $clonedCircle->getColor());
        $this->assertEquals("0,0", $clonedCircle->getPosition());
    }


    //car tests
    public function testCanCreateAutomaticCarWithClone()
    {
        $automaticProtoTypeCar = new AutomaticCarProtoType();
        //create 10 cars without touch AbstractCarProtoType
        for($i = 1 ; $i <= 10 ; $i++){
            $newCar = clone $automaticProtoTypeCar ; 
            $this->assertInstanceOf(AutomaticCarProtoType::class , $newCar);
        }

    }

    public function testCanCreateManualCarWithClone() 
    {
        $ManualProtoTypeCar = new ManualCarProtoType();
        for($i = 1 ; $i <= 10 ; $i++){
            $newCar = clone $ManualProtoTypeCar ; 
            $this->assertInstanceOf(ManualCarProtoType::class , $newCar);
        }
    }
}