<?php 

namespace Behavioral\Observer\pubsub;

//Concrete Subscribers (Observers) 
//These are the actual services that implement the SubscriberInterface.
//They define how to react to the messages published by the MessageBroker.
class NotificationService implements SubscriberInterface {
    public function update(string $topic, string $message): void {
        echo "[NotificationService] Push notification for '{$topic}': {$message}\n";
    }
}