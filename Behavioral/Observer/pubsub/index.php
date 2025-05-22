<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

// Create a broker instance
use Behavioral\Observer\pubsub\EmailService;
use Behavioral\Observer\pubsub\LoggingService;
use Behavioral\Observer\pubsub\NotificationService;
use Behavioral\Observer\pubsub\MessageBroker;

$broker = new MessageBroker();

// Create subscribers
$emailService = new EmailService();
$loggingService = new LoggingService();
$notificationService = new NotificationService();

// Subscribe services to topics
$broker->subscribe("order.created", $emailService);
$broker->subscribe("order.created", $loggingService);
$broker->subscribe("user.registered", $notificationService);

// Publish messages
$broker->publish("order.created", "Order #1234 has been placed.");
$broker->publish("user.registered", "User JohnDoe has registered.");
$broker->publish("payment.failed", "Payment for Order #1234 failed.");

