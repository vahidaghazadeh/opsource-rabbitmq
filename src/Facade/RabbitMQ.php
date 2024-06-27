<?php

namespace Opsource\Rabbitmq\Facade;

use Illuminate\Support\Facades\Facade;
use Opsource\Rabbitmq\Tools\ConnectionConfig;
use PhpAmqpLib\Connection\AbstractConnection;

/**
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager getConnections()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager getConfig()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager getApp()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager getChannels()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager resolveDefaultConfigName()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager resolveConnection(?string $name = null, ?ConnectionConfig $config = null)
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager resolveConfig()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager publisher()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager consumer()
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager resolveChannelId(?int $channelId, ?string $connectionName = null)
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager resolveChannel(?string $connectionName = null, ?int $channelId = null,?AbstractConnection $connection = null)
 * @method \Opsource\Rabbitmq\Builder\RabbitMQManager akeConnection(ConnectionConfig $config): AbstractConnection
 */
class RabbitMQ extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rabbitmq';
    }
}
