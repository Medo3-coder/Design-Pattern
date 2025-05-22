<?php 

namespace Behavioral\Observer\pubsub;

//Concrete Subscribers (Observers) 
//These are the actual services that implement the SubscriberInterface.
//They define how to react to the messages published by the MessageBroker.

class LoggingService implements SubscriberInterface {
    public function update(string $topic, string $message): void {
        echo "[LoggingService] Logged message on '{$topic}': {$message}\n";
    }
}