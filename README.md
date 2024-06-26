# RabbitMQ Queue driver Laravel

| Version | Laravel support | Last update  |
| :---          |           :---:             |                 ---:   |
| 1.0.3      | 9-10-11                | 26 June 2024|

# Installation
You can install this package using this composer:
```composer
composer require opsource/rabbitmq
```
# Configuration
After installation, the package will be published automatically
You can find the package configuration file in the path ```config/rabbitmq.php```

To use the package, you need to include the following environment variables in your project's ``.env'' file.
```env
RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USERNAME=admin
RABBITMQ_PASSWORD=admin
RABBITMQ_VHOST='/'
```

# RabbitMQ Environment Variables

This section outlines the RabbitMQ environment variables used to configure the connection and behavior of the RabbitMQ client.
Optional environment variables that you can use to develop your application

| Variable | Description |
| --- | --- |
| `RABBITMQ_HOST` | The hostname or IP address of the RabbitMQ server. Default: `127.0.0.1`. |
| `RABBITMQ_PORT` | The port number on which RabbitMQ is running. Default: `5672`. |
| `RABBITMQ_USERNAME` | The username for authenticating with RabbitMQ. Default: `admin`. |
| `RABBITMQ_PASSWORD` | The password for authenticating with RabbitMQ. Default: `admin`. |
| `RABBITMQ_VHOST` | The virtual host to use when connecting to RabbitMQ. Default: `/`. |
| `RABBITMQ_WORKER` | The worker mode for message delivery. Default: `DELIVERY_MODE_NON_PERSISTENT`. |
| `RABBITMQ_CONNECTION` | The name of the RabbitMQ connection. Default: `rabbitmq`. |
| `RABBITMQ_MESSAGE_DELIVERY_MODE` | The delivery mode for messages. Default: `DELIVERY_MODE_PERSISTENT`. |
| `RABBITMQ_EXCHANGE_NAME` | The name of the exchange. Default: `/`. |
| `RABBITMQ_EXCHANGE_DECLARE` | Whether to declare the exchange. Default: `false`. |
| `RABBITMQ_EXCHANGE_TYPE` | The type of exchange (e.g., direct, fanout, topic, headers). Default: `[direct fanout topic headers direct]`. |
| `RABBITMQ_EXCHANGE_PASSIVE` | Whether the exchange is passive. Default: `false`. |
| `RABBITMQ_EXCHANGE_DURABLE` | Whether the exchange should be durable. Default: `true`. |
| `RABBITMQ_EXCHANGE_AUTO_DEL` | Whether the exchange should be auto-deleted. Default: `false`. |
| `RABBITMQ_EXCHANGE_INTERNAL` | Whether the exchange is internal. Default: `false`. |
| `RABBITMQ_EXCHANGE_NOWAIT` | Whether to wait for the exchange to be declared. Default: `false`. |
| `RABBITMQ_QUEUE_DECLARE` | Whether to declare the queue. Default: `false`. |
| `RABBITMQ_QUEUE_PASSIVE` | Whether the queue is passive. Default: `false`. |
| `RABBITMQ_QUEUE_DURABLE` | Whether the queue should be durable. Default: `true`. |
| `RABBITMQ_QUEUE_EXCLUSIVE` | Whether the queue is exclusive. Default: `false`. |
| `RABBITMQ_QUEUE_AUTO_DEL` | Whether the queue should be auto-deleted. Default: `false`. |
| `RABBITMQ_QUEUE_NOWAIT` | Whether to wait for the queue to be declared. Default: `false`. |
| `RABBITMQ_CONSUMER_TAG` | The consumer tag. Default: `''` (empty string). |
| `RABBITMQ_CONSUMER_NO_LOCAL` | Whether to consume messages locally. Default: `false`. |
| `RABBITMQ_CONSUMER_NO_ACK` | Whether to acknowledge messages automatically. Default: `false`. |
| `RABBITMQ_CONSUMER_EXCLUSIVE` | Whether the consumer is exclusive. Default: `false`. |
| `RABBITMQ_CONSUMER_NOWAIT` | Whether to wait for the consumer. Default: `false`. |
| `RABBITMQ_CONSUMER_SLEEP_MS` | The sleep duration in milliseconds for the consumer. Default: `1000`. |
| `RABBITMQ_QOS_ENABLED` | Whether Quality of Service (QoS) is enabled. Default: `false`. |
| `RABBITMQ_QOS_PREF_SIZE` | The prefetch size for QoS. Default: `0`. |
| `RABBITMQ_QOS_PREF_COUNT` | The prefetch count for QoS. Default: `1`. |
| `RABBITMQ_QOS_GLOBAL` | Whether QoS is global. Default: `false`. |

These environment variables help configure the RabbitMQ connection and control various behaviors of the RabbitMQ client.

# RabbitMQ Integration Documentation

This document outlines the usage of the RabbitMQManager in your application.

## Initialization

First, create an instance of the `RabbitMQManager` class using the application container:

```php
$rabbitMQ = new RabbitMQManager(app());
```

Alternatively, you can retrieve the RabbitMQ instance directly from the application container using the alias rabbitmq:
```php
$rabbitMQ = app('rabbitmq');
```
# Constructor Dependency Injection
To inject the RabbitMQManager into a class using constructor dependency injection, define your class constructor to accept a RabbitMQManager instance:
```php
class YourClass {
    protected $rabbitMQ;

    // Constructor method
    public function __construct(RabbitMQManager $rabbitMQ) {
        $this->rabbitMQ = $rabbitMQ;
    }

    // Other methods...
}
```

# Getting RabbitMQ Connections
You can retrieve the list of all RabbitMQ connections using the getConnections method provided by the RabbitMQ facade:

```php
$connections = RabbitMQ::getConnections();
```

# Complete Example
Here’s a complete example of how to use RabbitMQManager in a class:
```php
use App\Services\RabbitMQManager;
use Illuminate\Support\Facades\RabbitMQ;

class YourService {
    protected $rabbitMQ;

    public function __construct(RabbitMQManager $rabbitMQ) {
        $this->rabbitMQ = $rabbitMQ;
    }

    public function handle() {
        // Retrieve all RabbitMQ connections
        $connections = RabbitMQ::getConnections();

        // Perform operations using the $rabbitMQ instance
        // Example: $this->rabbitMQ->publishMessage($message);
    }
}

// Usage in a controller or another service
$service = new YourService(app('rabbitmq'));
$service->handle();

```

# Key Points

- Initialization: You can initialize the RabbitMQManager either directly or through the application container.
- Dependency Injection: Use constructor dependency injection to inject the RabbitMQManager into your classes.
- Connections: Retrieve all RabbitMQ connections using RabbitMQ::getConnections().

This documentation provides a clear and concise explanation of how to use the `RabbitMQManager` and related functionalities in your application. It covers initialization, dependency injection, and retrieving connections, along with a complete example for better understanding.

# RabbitMQ Integration Documentation

This document provides an overview and examples of how to use RabbitMQ for publishing and consuming messages, resolving connections and channels, and configuring the RabbitMQ setup in your application.

## Publishing Messages
### `Single Message Publishing`

To publish a single message to the default exchange/topic/queue:

```php
$message = new RabbitMQMessage('message body');
```

Publish to the default exchange/topic/queue
$rabbitMQ->publisher()->publish($message);

# Bulk Messages
Publish multiple messages at once:
```php
$messages = [
    new RabbitMQMessage('message 1'),
    new RabbitMQMessage('message 2')
];

$rabbitMQ->publisher()->publish($messages);
```
# Consume Messages
### `Consume through a Closure`
Define a handler using a closure to consume messages:

```php
$handler = new RabbitMQGenericMessageConsume(function (RabbitMQIncomingMessage $message) {
    $content = $message->getStream();
});
```

# Consume through a Class
Define a handler using a class to consume messages:

```php
class MyMessageConsumer extends RabbitMQMessageConsumer {
    public function handle(RabbitMQIncomingMessage $message) {
        $content = $message->getStream();
    }
}

$handler = new MyMessageConsumer();

// Starts a blocking loop `while (true)`
$rabbitMQ->consumer()->consume($handler);
```

# Interact with RabbitMQ
### `Resolve the Default Connection`
Get the default connection:

```php
$amqpConnection = $rabbitMQ->resolveConnection();
```

# Resolve the Default Channel
Get the default channel:
```php
$amqpChannel = $rabbitMQ->resolveChannel();
```
# Configuration
### `Connection Configuration` 

Override the default connection configuration:

```php
$connectionName = 'custom_connection'; // Set to `null` for default connection
$connectionConfig = new ConnectionConfig(['username' => 'quest', 'password' => 'quest']);
$connectionConfig->setHost('localhost');
$customConnection = $rabbitMQ->resolveConnection($connectionName, $connectionConfig);

```

# Message Configuration
Configure the message properties:
```php
$config = [
    'content_encoding' => 'UTF-8',
    'content_type'     => 'text/plain',
    'delivery_mode'    => AMQPMessage::DELIVERY_MODE_PERSISTENT,
];
$message = new RabbitMQMessage('message body', $config);

// Set message exchange
$exchangeConfig = ['type' => AMQPExchangeType::DIRECT];
$exchange = new RabbitMQExchange('my_exchange', $exchangeConfig);
$message->setExchange($exchange);

```

# Publish Configuration
Configure the publisher and publish a message with specific settings:

```php
$publisher = $rabbitMQ->publisher();
$message = new RabbitMQMessage('message body');

$exchangeConfig = ['type' => AMQPExchangeType::TOPIC];
$exchange = new RabbitMQExchange('my_exchange', $exchangeConfig);
$message->setExchange($exchange);

$routingKey = 'key'; // Can be an empty string, but not null
$connectionName = 'custom_connection'; // Set to null for default connection

$publishConfig = new PublishConfig(['exchange' => ['type' => AMQPExchangeType::FANOUT]]);
$publisher->publish($message, $routingKey, $connectionName, $publishConfig);

```

# Consumer Configuration
Configure the consumer settings:

```php
$consumer = $rabbitMQ->consumer();
$routingKey = 'key';

$exchange = new RabbitMQExchange('test_exchange', ['declare' => true, 'durable' => true]);
$queue = new RabbitMQQueue('my_queue', ['declare' => true, 'durable' => true]);

$messageConsumer = new RabbitMQGenericMessageConsumer(
    function (RabbitMQIncomingMessage $message) {
        // Acknowledge a message
        $message->getDelivery()->acknowledge();
        // Reject a message
        $requeue = true; // Reject and Requeue
        $message->getDelivery()->reject($requeue);
    },
    $this,
);

// A1. Set the exchange and the queue directly
$messageConsumer
    ->setExchange($exchange)
    ->setQueue($queue);

// OR

// A2. Set the exchange and the queue through config
$consumeConfig = new ConsumeConfig(
  [
    'queue' => [
        'name' => 'my_queue',
        'declare' => true,
        'durable' => true,
    ],
    'exchange' => [
        'name' => 'test_exchange',
        'declare' => true,
    ],
  ],
);

$consumer->consume($messageConsumer, $routingKey, null, $consumeConfig);

```

# Example
### `Running a Consumer`

1. Create a Custom Command:
```php
php artisan make:command MyRabbitConsumer --command "rabbitmq:my-consumer {--queue=} {--exchange=} {--routingKey=}"

```
2. Register the Command in `app/Console/Kernel.php`:
```php
protected $commands = [
    MyRabbitConsumer::class,
];
```
3. Consume through the Handler:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kunnu\RabbitMQ\RabbitMQQueue;
use Kunnu\RabbitMQ\RabbitMQExchange;
use Kunnu\RabbitMQ\RabbitMQIncomingMessage;
use Kunnu\RabbitMQ\RabbitMQGenericMessageConsumer;

class MyRabbitConsumer extends Command
{
    protected $signature = 'rabbitmq:my-consumer {--queue} {--exchange} {--routingKey}';
    protected $description = 'My consumer command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $rabbitMQ = app('rabbitmq');
        $messageConsumer = new RabbitMQGenericMessageConsumer(
            function (RabbitMQIncomingMessage $message) {
                // Handle message
                $this->info($message->getStream()); // Print to console
            },
            $this,
        );

        $routingKey = $this->option('routingKey') ?? '';
        $queue = new RabbitMQQueue($this->option('queue') ?? '', ['declare' => true]);
        $exchange = new RabbitMQExchange($this->option('exchange') ?? '', ['declare' => true]);

        $messageConsumer
            ->setExchange($exchange)
            ->setQueue($queue);

        $rabbitMQ->consumer()->consume($messageConsumer, $routingKey);
    }
}

```
4. Call the Command from the Console:
```shell
php artisan rabbitmq:my-consumer --queue='my_queue' --exchange='test_exchange' --routingKey='key'
```

# Publishing Messages
1. Create Route <-> Controller Binding:
```shell
Route::get('/publish', 'MyRabbitMQController@publish');

```
2. Create a Controller to Publish Messages:
```shell
class MyRabbitMQController extends Controller {
    public function publish(Request $request)
    {
        $rabbitMQ = app('rabbitmq');
        $consumer = $rabbitMQ->consumer();
        $routingKey = 'key'; // The key used by the consumer

        // The exchange (name) used by the consumer
        $exchange = new RabbitMQExchange('test_exchange', ['declare' => true]);

        $contents = $request->get('message', 'random message');

        $message = new RabbitMQMessage($contents);
        $message->setExchange($exchange);

        $rabbitMQ->publisher()->publish(
            $message,
            $routingKey
        );

        return ['message' => "Published {$contents}"];
    }
}

```

By following this documentation, you can effectively publish and consume messages using RabbitMQ in your application.

This documentation provides a comprehensive guide on how to set up, configure, publish, and consume messages using RabbitMQ, along with example code and commands for better understanding.

# License
The MIT License (MIT). Please see [License File](./LICENSE.md) for more information.