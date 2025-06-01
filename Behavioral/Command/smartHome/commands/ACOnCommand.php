<?php 

namespace Behavioral\Command\smartHome\commands;

use Behavioral\Command\smartHome\devices\AirConditioner;

// Command for turning on the air conditioner in a smart home system
class ACOnCommand implements Command
{
    private $ac;

    public function __construct(AirConditioner $ac)
    {
        $this->ac = $ac;
    }
    public function execute()
    {
        $this->ac->on();
    }

    public function undo()
    {
        $this->ac->off();
    }
  
}