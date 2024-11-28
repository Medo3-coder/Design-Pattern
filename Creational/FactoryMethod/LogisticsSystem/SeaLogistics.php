<?php

namespace Creational\FactoryMethod\LogisticsSystem;

class SeaLogistics implements LogisticsFactory {

    public function createTransport(): Transport {
        return new Ship();
    }
}