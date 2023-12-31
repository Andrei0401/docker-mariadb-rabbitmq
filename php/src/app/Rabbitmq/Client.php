<?php

namespace App\Rabbitmq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Description of RabbitmqClient
 *
 * @author user
 */
class Client {

    private static $config;

    public static function setConfig($config)
    {
        self::$config = $config;
    }

    public static function publishMessage($messageBody, $exchange = 'router', $queue = 'msgs')
    {
        $connection = new AMQPStreamConnection(...self::$config);
        $channel = $connection->channel();

        /*
            The following code is the same both in the consumer and the producer.
            In this way we are sure we always have a queue to consume from and an
                exchange where to publish messages.
        */

        /*
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
        $channel->queue_declare($queue, false, true, false, false);

        /*
            name: $exchange
            type: direct
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */

        $channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

        $channel->queue_bind($queue, $exchange);

        $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $exchange);

        $channel->close();
        $connection->close();
    }

    public static function receiveMessage($exchange = 'router', $queue = 'msgs')
    {
        $connection = new AMQPStreamConnection(...self::$config);
        $channel = $connection->channel();

        /*
            The following code is the same both in the consumer and the producer.
            In this way we are sure we always have a queue to consume from and an
                exchange where to publish messages.
        */

        /*
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
        $channel->queue_declare($queue, false, true, false, false);

        /*
            name: $exchange
            type: direct
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */

        $channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

        $channel->queue_bind($queue, $exchange);

        $message = $channel->basic_get($queue);
        if (!$message) {
            return $message;
        }
        $message->ack();

        $channel->close();
        $connection->close();

        return $message->body;
    }

}
