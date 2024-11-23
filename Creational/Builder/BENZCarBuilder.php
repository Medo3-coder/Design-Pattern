<?php

use Creational\Builder\CarBuilderInterface;
use Creational\Builder\Models\BenzCar;
use Creational\Builder\Models\Car;

class BENZCarBuilder implements CarBuilderInterface
{
      /**
     * @var Car $type
     */

     private $type;

     public function createCar() {
         $this->type = new BenzCar();
     }
 
     public function addBody() {
         $this->type->setPart('BODY', 'body');
     }
 
     public function addEngine() {
         $this->type->setPart('ENGINE', 'engine');
     }
 
     public function addDoors() {
         $this->type->setPart('DOORS', 'doors');
     }
 
     public function addWheel() {
         $this->type->setPart('WHEEL', 'wheel');
     }
 
     public function getCar() : Car {
         return $this->type;
     }
}