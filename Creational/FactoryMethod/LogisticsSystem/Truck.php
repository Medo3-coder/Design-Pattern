<?php 

namespace Creational\FactoryMethod\LogisticsSystem;



class Truck implements Transport {

    public function deliver(): string{
        return "Delivering cargo by land using a Truck.";
    }
}