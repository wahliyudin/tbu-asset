<?php

namespace App\Kafka\Enums;

enum Nested: string
{
    case CATEGORY = 'category';
    case CLUSTER = 'cluster';
    case UNIT = 'unit';
    case LEASING = 'leasing';
    case ACTIVITY = 'activity';
    case UOM = 'uom';
    case SUB_CLUSTER = 'sub_cluster';
    case CONDITION = 'condition';
    case ASSET = 'asset';
    case ASSET_REQUEST = 'asset_request';
    case ASSET_TRANSFER = 'asset_transfer';
    case ASSET_DISPOSE = 'asset_dispose';
}
