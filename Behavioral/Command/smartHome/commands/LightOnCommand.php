<?php

namespace Behavioral\Command\smartHome\commands;

use Behavioral\Command\smartHome\devices\Light;

// Command for turning on the light in a smart home system
class LightOnCommand implements Command
{
    private $light;

    public function __construct(Light $light)
    {
        $this->light = $light;
    }

    public function execute()
    {
        $this->light->on();
    }

    public function undo()
    {
        $this->light->off();
    }
}