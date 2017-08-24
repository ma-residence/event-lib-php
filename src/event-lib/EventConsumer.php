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

        $id = is_array($eventMessage->getId()) ? json_encode($eventMessage->getId()) : $eventMessage->getId();
        $this->logger->info("Consuming event message '{$eventMessage->getEvent()}' for {$eventMessage->getModelType()}:{$id}");

        return $this->consumeEvent($eventMessage);
    }

    protected abstract function consumeEvent(EventMessage $eventMessage): int;
}
