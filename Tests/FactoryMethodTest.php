<?php

use Creational\FactoryMethod\CarSystem\BenzBrand;
use Creational\FactoryMethod\CarSystem\BENZBrandFactory;
use Creational\FactoryMethod\CarSystem\BmwBrand;
use Creational\FactoryMethod\CarSystem\BMWBrandFactory;
use Creational\FactoryMethod\LogisticsSystem\RoadLogistics;
use Creational\FactoryMethod\LogisticsSystem\SeaLogistics;
use Creational\FactoryMethod\LogisticsSystem\Ship;
use Creational\FactoryMethod\LogisticsSystem\Truck;
use PHPUnit\Framework\TestCase;

class FactoryMethodTest extends TestCase
{
    public function testCanBuildBMWBrand()
    {
        $brandFactory = new BMWBrandFactory();
        $mybrand = $brandFactory->BuildBrand();
        $this->assertInstanceOf(BmwBrand::class , $mybrand);
    }

    public function testCanBuildBENZBrand()
    {
        $brandFactory = new BENZBrandFactory();
        $mybrand = $brandFactory->BuildBrand();
        $this->assertInstanceOf(BenzBrand::class , $mybrand);
    }

    public function testRoadLogisticsCreatesTruck(){
        
        // Arrange: Create an instance of RoadLogistics
        $logistics  = new RoadLogistics();

        // Call the createTransport method
        $transport = $logistics->createTransport();

        // Assert: Check if the transport is an instance of Truck
        $this->assertInstanceOf(Truck::class , $transport);
    }

    public function testSeaLogisticsCreatesShip(){
        
        // Arrange: Create an instance of SeaLogistics
        $logistics = new SeaLogistics();

        // Act: Call the createTransport method
        $transport = $logistics->createTransport();

        // Assert: Check if the transport is an instance of Ship
        $this->assertInstanceOf(Ship::class , $transport);


    }
}