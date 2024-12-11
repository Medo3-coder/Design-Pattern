<?php 

namespace Creational\Prototype\graphicsEditor;

use Creational\ProtoType\graphicsEditor\Prototype;

class Shape implements Prototype {

    private $type;
    private $color;
    private $position;

    public function __construct($type , $color , $position)
    {
         $this->type = $type;
         $this->color = $color;
         $this->position = $position;
    }

    public function clone(): Prototype {
        return new Shape( $this->type ,  $this->color ,  $this->position);
    }

    public function setPosition(string $position): void {
        $this->position = $position;
    }
    public function getType(): string {
        return $this->type;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function getPosition(): string {
        return $this->position;
    }

}