<?php

namespace Behavioral\Command\smartHome\invoker;

use Behavioral\Command\smartHome\commands\Command;

class RemoteControl {
    private $commands = [];
    //The $lastCommand variable can either be an object that implements the Command interface or null.
    private $lastCommand;


    public function setCommand(string $button, Command $command): void
    {
        $this->commands[$button] = $command;

    }

    public function pressButton(string $button): void {
        if(isset($this->commands[$button])) {
            $this->commands[$button]->execute();
            $this->lastCommand = $this->commands[$button];
        }else {
            echo "No command set for slot: $button\n";
        }
    }

    public function pressUndo(): void {
            if($this->lastCommand){
                $this->lastCommand->undo();
                $this->lastCommand = null;
            }
    }

}