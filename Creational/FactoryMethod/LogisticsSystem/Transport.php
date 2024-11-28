<?php

namespace Creational\FactoryMethod\LogisticsSystem;

interface Transport  {
    public function deliver() : string;
}

