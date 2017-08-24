<?php

namespace MR\Event;

use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class EventProducer
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Producer $producer, LoggerInterface $logger = null)
    {
        $this->producer = $producer;
        $this->logger = $logger ?: new NullLogger();
    }

    protected function publishEvent(EventMessage $eventMessage)
    {
        $this->logger->info("Publishing an event message '{$eventMessage->getEvent()}' for {$eventMessage->getEvent()}:{$eventMessage->getId()}");

        $this->producer->publish($eventMessage->jsonSerialize());
    }
}
