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
    protected $logger;

    public function __construct(Producer $producer, LoggerInterface $logger = null)
    {
        $this->producer = $producer;
        $this->logger = $logger ?: new NullLogger();
    }

    protected function publishEvent(EventMessage $eventMessage)
    {
        if ("Psr\Log\NullLogger" !== $this->logger::class) {
            $id = is_array($eventMessage->getId()) ? json_encode($eventMessage->getId()) : $eventMessage->getId();
            $this->logger->info("Publishing an event message '{$eventMessage->getEvent()}' for {$eventMessage->getModelType()}:{$id}");
        }

        $this->producer->publish($eventMessage->jsonSerialize());
    }
}
