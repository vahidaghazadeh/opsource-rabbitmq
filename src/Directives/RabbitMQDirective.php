<?php

namespace Opsource\Rabbitmq\Directives;

use Illuminate\Support\Facades\Log;
use Opsource\Rabbitmq\Builder\RabbitMQExchange;
use Opsource\Rabbitmq\Builder\RabbitMQManager;
use Opsource\Rabbitmq\Builder\RabbitMQMessage;
use Opsource\Rabbitmq\Builder\RabbitMQPublisher;
use Opsource\Rabbitmq\Builder\RabbitMQQueue;
use Opsource\Rabbitmq\Tools\PublishConfig;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQDirective
{
    protected RabbitMQManager $rabbitMQ;
    protected RabbitMQPublisher $publisher;
    protected PublishConfig $publisherConfig;
    protected RabbitMQExchange $exchange;
    protected RabbitMQMessage $message;
    protected RabbitMQQueue $quote;
    protected PublishConfig $publishConfig;
    protected array $exchange_config;

    public function __construct()
    {
        $this->rabbitMQ = new RabbitMQManager(app());
        $this->setExchangeConfig();
    }

    public static function getInstance(): RabbitMQDirective
    {
        $instance = app(self::class);
        $instance->rabbitMQ = new RabbitMQManager(app());
        $instance->setExchangeConfig();
        return $instance;
    }

    public function init(array $data, string $queue): static
    {
        try {
            $this->setMessage($data)->setExchange($queue)->getMessage()->setExchange($this->getExchange());
            $this->setQuote($queue)->setPublisher();
            return $this;
        } catch (\Exception|\Error|\Throwable $ex) {
            Log::debug($ex->getMessage());
        }
    }

    public function publish(): string
    {
        $this->getPublisher()->publish(
            $this->getMessage(),
            $this->getQuote()->getName(),
            '',
            $this->getPublisherConfig()
        );
        return "success";
    }

    protected function setMessage($message): static
    {
        $this->message = new RabbitMQMessage(json_encode($message, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    /**
     * @return RabbitMQExchange
     */
    protected function getExchange(): RabbitMQExchange
    {
        return $this->exchange;
    }

    /**
     * @param  string  $exchange
     * @return static
     */
    protected function setExchange(string $exchange): static
    {
        $this->exchange = new RabbitMQExchange($exchange, $this->getExchangeConfig());
        return $this;
    }

    /**
     * @return array{type: string, durable: true, declare: true, delivery_mode: int}
     */
    protected function getExchangeConfig(): array
    {
        return $this->exchange_config;
    }

    protected function setExchangeConfig(array $config = null): static
    {
        $this->exchange_config = $config ?: [
            'type' => AMQPExchangeType::DIRECT,
            'durable' => true,
            'declare' => true,
            'delivery_mode' => 2
        ];
        return $this;
    }

    protected function getMessage(): RabbitMQMessage
    {
        return $this->message;
    }

    /**
     * @return RabbitMQPublisher
     */
    protected function getPublisher(): RabbitMQPublisher
    {
        return $this->publisher;
    }

    protected function setPublisher(): static
    {
        $this->publisher = $this->rabbitMQ->publisher();
        return $this;
    }


    /**
     * @return PublishConfig
     */
    protected function getPublisherConfig(): PublishConfig
    {
        $this->setPublisherConfig();
        return $this->publisherConfig;
    }

    /**
     * @return static
     */
    protected function setPublisherConfig(): static
    {
        $this->publisherConfig = new PublishConfig([
            'exchange' => $this->getExchangeConfig(),
            'queue' => $this->quote
        ]);

        return $this;
    }

    /**
     * @return RabbitMQQueue
     */
    protected function getQuote(): RabbitMQQueue
    {
        return $this->quote;
    }

    /**
     * @param  string  $quote
     * @return static
     */
    protected function setQuote(string $quote): static
    {
        $this->quote = new RabbitMQQueue($quote, ['durable' => true, 'declare' => true]);
        return $this;
    }

}
