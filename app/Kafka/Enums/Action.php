<?php

namespace App\Kafka\Enums;

enum Action: string
{
    case UPDATE_OR_CREATE = 'update_or_create';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
}
