<?php

namespace Behavioral\Command\smartHome\devices;

class AirConditioner
{
    public function on()
    {
        echo "Air Conditioner is turned ON\n";
    }

    public function off()
    {
        echo "Air Conditioner is turned OFF\n";
    }
}