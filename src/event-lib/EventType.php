<?php

namespace MR\Event;

use Greg0ire\Enum\AbstractEnum;

final class EventType extends AbstractEnum
{
    // Doctrine Events
    const CREATED = 'created';
    const UPDATED = 'updated';
    const DELETED = 'deleted';
}
