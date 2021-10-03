<?php

namespace App\Services\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use function PHPUnit\Framework\stringContains;

class RabbitMqService
{
    public function sendRabbitMqMessage(string $message, string $exchangeName = "direct_messages") {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->exchange_declare($exchangeName, 'direct', false, false, false);
        // $channel->queue_declare($rabbitRoutingKey, false, true, false, false);
        // $msg = new AMQPMessage($message, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT));
        $msg = new AMQPMessage($message);
        // $channel->basic_publish($msg, '', $rabbitRoutingKey);
        $severity = str_contains($message, '777') ? 'critical' : 'regular';
        $channel->basic_publish($msg, $exchangeName, $severity);
        // echo ' [x] Sent ', $severity, ':', $message, "\n";
        $channel->close();
        $connection->close();
    }
}