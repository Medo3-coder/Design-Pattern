<?php

namespace Creational\FactoryMethod\LogisticsSystem;

class RoadLogistics implements LogisticsFactory {

    public function createTransport(): Transport {
        return new Truck();
    }
}