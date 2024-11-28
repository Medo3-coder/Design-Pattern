<?php

namespace Creational\FactoryMethod\CarSystem;

class BenzBrand implements CarBrandInterFace {
    public function createBrand() {
        return "BenzBrand";

    }
}