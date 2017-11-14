<?php

namespace MR\Event;

class EventException extends \Exception
{
    public static function invalidEventType(string $type): EventException
    {
        return new self("The given event type '$type' is invalid and not defined in MR\Event\EventType");
    }

    public static function invalidIdFormat($id): EventException
    {
        $type = (is_object($id)) ? get_class($id) : gettype($id);

        return new self("The given id is a '$type' instead of a string or an array.");
    }

    public static function errorDuringUnserialization(string $error): EventException
    {
        return new self("An error occur during the unserialization of a MR\Event\EventMessage with the following: '$error'");
    }
}
