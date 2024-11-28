<?php

namespace Creational\FactoryMethod\CarSystem;

class BmwBrand  implements CarBrandInterFace {
    public function createBrand() {
        return "BmwBrand";

    }
}