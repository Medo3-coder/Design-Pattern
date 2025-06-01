<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
// Client setup

use Behavioral\Command\smartHome\commands\ACOnCommand;
use Behavioral\Command\smartHome\devices\AirConditioner;
use Behavioral\Command\smartHome\commands\LightOnCommand;
use Behavioral\Command\smartHome\invoker\RemoteControl;
use Behavioral\Command\smartHome\devices\Light;

$light = new Light();
$Ac = new AirConditioner();

$lightCommand = new LightOnCommand($light);
$acCommand = new ACOnCommand($Ac);

// Execute commands

$remote = new RemoteControl();
$remote->setCommand("A" , $lightCommand);
$remote->setCommand("B" , $acCommand);

//test
$remote->pressButton("A"); // Light is turned ON
$remote->pressButton("B"); // Air Conditioner is turned ON
$remote->pressUndo(); // Air Conditioner is turned OFF
// $remote->pressUndo(); // Light is turned OFF

// run this file in seprate terminal
