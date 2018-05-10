<?php

namespace MR\Event;

class EventException extends \Exception
{
    public static function invalidEventType(string $type): self
    {
        return new self("The given event type '$type' is invalid and not defined in MR\Event\EventType");
    }

    public static function invalidIdFormat($id): self
    {
        if (is_object($id)) {
            $type = get_class($id);
        } else {
            $type = gettype($id);
        }

        return new self("The given id is a '$type' instead of a string or an array.");
    }

    public static function errorDuringUnserialization(string $error): self
    {
        return new self("An error occur during the unserialization of a MR\Event\EventMessage with the following: '$error'");
    }
}
