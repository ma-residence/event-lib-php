<?php

namespace MR\Event;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class EventConsumer implements ConsumerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    public function execute(AMQPMessage $msg)
    {
        $eventMessage = (new EventMessage())->jsonUnserialize($msg->getBody());

        $this->logger->info("Consuming event message '{$eventMessage->getEvent()}' for {$eventMessage->getModelType()}:{$eventMessage->getId()}");

        $this->consumeEvent($eventMessage);
    }

    protected abstract function consumeEvent(EventMessage $eventMessage);
}
