<?php 

namespace Behavioral\Command\smartHome\commands;

// Command interface for the Command pattern
interface Command {
    public function execute();
    public function undo();
}

