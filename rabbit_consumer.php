<?php
require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
$severity = $argv[1];
$channel->queue_bind($queue_name, 'direct_messages', $severity);
// $channel->queue_declare('new_message', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C. severity: " . $severity . "\n";

$callback = function ($msg) use ($severity) {
    echo ' [x] Received "', $msg->body, '", severity: ', $severity, "\n";
    // sleep(substr_count($msg->body, '.'));
    // echo " [x] Done\n";
    // $msg->ack();
};

// $channel->basic_qos(null, 1, null);
// $channel->basic_consume('new_message', '', false, false, false, false, $callback);
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
