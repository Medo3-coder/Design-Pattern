<?php

namespace Behavioral\Observer\pubsub;
use Behavioral\Observer\pubsub\SubscriberInterface;

//Concrete Subscribers (Observers) 
//These are the actual services that implement the SubscriberInterface.
//They define how to react to the messages published by the MessageBroker.
class EmailService implements SubscriberInterface {
    public function update(string $topic , string $message): void {
        echo "EmailService received message: {$message} for topic: {$topic}\n";
    }
}
