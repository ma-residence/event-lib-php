<?php

namespace MR\Event;

use Greg0ire\Enum\AbstractEnum;

final class EventType extends AbstractEnum
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    const DELETED = 'deleted';
    const ASK_CONFIRMATION_CODE = 'ask_confirmation_code';
}
