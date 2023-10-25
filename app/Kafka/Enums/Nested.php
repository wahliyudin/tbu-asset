<?php

namespace App\Kafka\Enums;

enum Nested: string
{
    case CATEGORY = 'category';
    case CLUSTER = 'cluster';
    case UNIT = 'unit';
    case LEASING = 'leasing';
    case SUB_CLUSTER = 'sub_cluster';
}
