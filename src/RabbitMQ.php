<?php

namespace Opsource\Rabbitmq;

use Illuminate\Support\Facades\Facade;

class RabbitMQ extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rabbitmq';
    }
}
