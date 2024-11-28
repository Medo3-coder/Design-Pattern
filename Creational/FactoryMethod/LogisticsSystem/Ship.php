<?php

namespace Creational\FactoryMethod\LogisticsSystem;

class Ship implements Transport {

    public function deliver(): string {
        return "Delivering cargo by sea using a Ship.";
    }
}