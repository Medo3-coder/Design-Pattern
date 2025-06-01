<?php 

namespace Behavioral\Command\smartHome\devices;

class Light {
    public function on()
    {
        echo "Light is turned ON\n";
    }

    public function off()
    {
        echo "Light is turned OFF\n";
    }
}