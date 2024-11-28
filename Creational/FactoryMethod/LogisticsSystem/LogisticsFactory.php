<?php

namespace Creational\FactoryMethod\LogisticsSystem;

interface LogisticsFactory {

    public function createTransport(): Transport;
}
