<?php 

namespace CreationalTests;

use Creational\ProtoType\CarSystem\AutomaticCarProtoType;
use Creational\ProtoType\CarSystem\ManualCarProtoType;
use PHPUnit\Framework\TestCase;

class ProtoTypeTest extends TestCase 
{
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