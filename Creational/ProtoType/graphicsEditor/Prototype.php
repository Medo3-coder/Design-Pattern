<?php

namespace Creational\ProtoType\graphicsEditor;

interface Prototype {
    public function clone (): Prototype;
}
