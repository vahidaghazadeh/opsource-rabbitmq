<?php

namespace Opsource\Rabbitmq\Exception;


class RabbitMQException extends \Exception
{
    public function __construct($message = 'RabbitMQ Error', $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
