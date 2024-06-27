<?php

namespace Opsource\Rabbitmq\Builder;

use Illuminate\Support\Collection;
use Opsource\Rabbitmq\Contracts\RabbitMQMessageConsumer;
use Opsource\Rabbitmq\Exception\RabbitMQException;
use Opsource\Rabbitmq\Tools\RabbitMQDelivery;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQIncomingMessage
{
    protected string $stream;

    protected Collection $config;

    protected ?RabbitMQExchange $exchange = null;

    protected ?RabbitMQQueue $queue = null;

    protected ?RabbitMQMessageConsumer $consumer = null;

    protected ?RabbitMQDelivery $deliveryInfo = null;

    protected ?AMQPMessage $amqpMessage = null;

    public function __construct(string $stream = '', array $config = [])
    {
        $this->stream = $stream;
        $this->setConfig($config);
    }

    /**
     * @param array $config
     *
     * @return \Opsource\Rabbitmq\RabbitMQIncomingMessage
     */
    public function setConfig(array $config): self
    {
        $this->config = new Collection($config);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getConfig(): Collection
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getStream(): string
    {
        return $this->stream;
    }

    /**
     * @param string $stream
     *
     * @return \Opsource\Rabbitmq\RabbitMQIncomingMessage
     */
    public function setStream(string $stream): self
    {
        $this->stream = $stream;

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

    /**
     * @return \Opsource\Rabbitmq\Tools\RabbitMQDelivery|null
     */
    public function getDelivery(): ?RabbitMQDelivery
    {
        return $this->deliveryInfo;
    }

    /**
     * @param \Opsource\Rabbitmq\Tools\RabbitMQDelivery|null $deliveryInfo
     *
     * @return \Opsource\Rabbitmq\RabbitMQIncomingMessage
     */
    public function setDelivery(?RabbitMQDelivery $deliveryInfo): self
    {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    /**
     * @return RabbitMQMessageConsumer|null
     */
    public function getConsumer(): ?RabbitMQMessageConsumer
    {
        return $this->consumer;
    }

    /**
     * @param RabbitMQMessageConsumer $consumer
     *
     * @return self
     */
    public function setConsumer(?RabbitMQMessageConsumer $consumer): self
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * @return \PhpAmqpLib\Message\AMQPMessage|null
     */
    public function getAmqpMessage(): ?AMQPMessage
    {
        return $this->amqpMessage;
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage|null $amqpMessage
     *
     * @return \Opsource\Rabbitmq\RabbitMQIncomingMessage
     */
    public function setAmqpMessage(?AMQPMessage $amqpMessage): RabbitMQIncomingMessage
    {
        $this->amqpMessage = $amqpMessage;

        return $this;
    }

    public function getMessageApplicationHeaders(): array
    {
        $amqp = $this->getAmqpMessage();
        $props = $amqp ? $amqp->get_properties() : [];

        return isset($props['application_headers']) ? $props['application_headers']->getNativeData() : [];
    }

    public function getMessageApplicationHeader($key, $default = null)
    {
        return array_key_exists($key, ($headers = $this->getMessageApplicationHeaders())) ? $headers[$key] : $default;
    }

    public function isRedelivered(): bool
    {
        $delivery = $this->getDelivery();
        $info = $delivery ? $delivery->getConfig()->get('delivery_info') : null;

        if (!$delivery || !$info) {
            throw new RabbitMQException('Delivery info not available.');
        }

        return (bool) ($info['redelivered'] ?? false);
    }
}
