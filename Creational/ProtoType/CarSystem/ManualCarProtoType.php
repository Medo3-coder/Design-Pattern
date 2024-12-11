<?php

namespace Creational\ProtoType\CarSystem;

class ManualCarProtoType extends AbstractCarProtoType { 

    protected $model = 'Manual';
    
    function __clone()
    {
        // TODO: Implement __clone() method.
    }

}