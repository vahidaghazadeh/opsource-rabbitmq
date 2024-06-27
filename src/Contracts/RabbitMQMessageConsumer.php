<?php

namespace Opsource\Rabbitmq\Contracts;

use Illuminate\Support\Collection;
use Opsource\Rabbitmq\Builder\RabbitMQExchange;
use Opsource\Rabbitmq\Builder\RabbitMQIncomingMessage;
use Opsource\Rabbitmq\Builder\RabbitMQQueue;

abstract class RabbitMQMessageConsumer
{
    protected Collection $config;

    protected ?RabbitMQExchange $exchange = null;

    protected ?RabbitMQQueue $queue = null;

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * Handle an incoming message.
     *
     * @param RabbitMQIncomingMessage $message
     * @return void
     */
    abstract public function handle(RabbitMQIncomingMessage $message): void;

    /**
     * Get config.
     *
     * @return Collection
     */
    public function getConfig(): Collection
    {
        return $this->config;
    }

    /**
     * Set configuration.
     *
     * @param array $config
     * @return self
     */
    public function setConfig(array $config): self
    {
        $this->config = new Collection($config);

        return $this;
    }

    /**
     * @return null|\Opsource\Rabbitmq\Builder\RabbitMQExchange|null
     */
    public function getExchange(): ?RabbitMQExchange
    {
        return $this->exchange;
    }

    /**
     * @param \Opsource\Rabbitmq\Builder\RabbitMQExchange|null $exchange
     *
     * @return self
     */
    public function setExchange(?RabbitMQExchange $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * @return null|\Opsource\Rabbitmq\Builder\RabbitMQQueue|null
     */
    public function getQueue(): ?RabbitMQQueue
    {
        return $this->queue;
    }

    /**
     * @param \Opsource\Rabbitmq\Builder\RabbitMQQueue|null $queue
     *
     * @return self
     */
    public function setQueue(?RabbitMQQueue $queue): self
    {
        $this->queue = $queue;

        return $this;
    }
}
