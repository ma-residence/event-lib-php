<?php

namespace MR\Event;

final class EventMessage implements \JsonSerializable
{
    /**
     * @var string
     */
    private $event;

    /**
     * @var string|array
     */
    private $id;

    /**
     * @var string
     */
    private $modelType;

    /**
     * @var array
     */
    private $metadata;

    public function __construct(string $event = null, $id = null, string $modelType = null, array $metadata = [])
    {
        if ($event && !EventType::isValidValue($event)) {
            throw EventException::invalidEventType($event);
        }

        if ($id && !is_string($id) && !is_array($id)) {
            throw EventException::invalidIdFormat($id);
        }

        $this->event = $event;
        $this->id = $id;
        $this->modelType = $modelType;
        $this->metadata = $metadata;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return array|string
     */
    public function getId()
    {
        return $this->id;
    }

    public function getModelType(): string
    {
        return $this->modelType;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function jsonSerialize(): string
    {
        return json_encode([
            'id' => $this->id,
            'model_type' => $this->modelType,
            'event' => $this->event,
            'metadata' => $this->metadata,
        ]);
    }

    public function jsonUnserialize(string $json): EventMessage
    {
        if (false === $data = json_decode($json, true)) {
            throw EventException::errorDuringUnserialization(json_last_error_msg());
        }

        $this->id = $data['id'];
        $this->modelType = $data['model_type'];
        $this->event = $data['event'];
        $this->metadata = $data['metadata'];

        return $this;
    }
}
