<?php
namespace Behavioral\Observer\pubsub;

use Behavioral\Observer\pubsub\SubscriberInterface;


//This is the subject (observable) in the observer pattern.
//It manages a list of subscribers and allows them to subscribe to topics.
//When a message is published, it notifies all subscribers of the topic.
class MessageBroker
{
    private $subscribers = [];

    public function subscribe(string $topic, SubscriberInterface $subscriber): void
    {
        $this->subscribers[$topic][] = $subscriber;
    }

    public function publish(string $topic, string $message): void
    {
        echo "Publishing to topic '{$topic}': {$message}\n";

        if (!empty($this->subscribers[$topic])) {
            foreach ($this->subscribers[$topic] as $subscriber) {
                $subscriber->update($topic, $message);
            }
        } else {
            echo "No subscribers for topic '{$topic}'.\n";
        }
    }
}


//This is your news agency. Each topic (like sports, weather, politics) has different subscribers. 
//When news is published, only the relevant subscribers are notified.