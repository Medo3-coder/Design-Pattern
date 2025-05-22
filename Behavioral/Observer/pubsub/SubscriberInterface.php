<?php 

namespace Behavioral\Observer\pubsub;


//Defines a contract for all observers (subscribers). They must implement the update() method, 
//which will be called when a new message is published

//Think of update() as how a news agency sends out notifications to all its subscribers when a story breaks.
interface SubscriberInterface {
    public function update(string  $topic , string $message);
}