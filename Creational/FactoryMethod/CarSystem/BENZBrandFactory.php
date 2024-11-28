<?php

namespace Creational\FactoryMethod\CarSystem;

class BENZBrandFactory implements BrandFactory {

    public function BuildBrand() {
        
        return new BenzBrand();
    }
}