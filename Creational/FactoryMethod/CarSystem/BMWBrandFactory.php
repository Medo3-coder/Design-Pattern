<?php

namespace Creational\FactoryMethod\CarSystem;

class BMWBrandFactory implements BrandFactory {

    public function BuildBrand() {
        
        return new BmwBrand();
    }
}