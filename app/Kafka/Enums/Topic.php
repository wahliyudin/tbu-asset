<?php

namespace App\Kafka\Enums;

enum Topic: string
{
    case CATEGORY = 'asset_category';
    case CLUSTER = 'asset_cluster';
    case SUB_CLUSTER = 'asset_sub_cluster';
    case UNIT = 'asset_unit';
    case LEASING = 'asset_leasing';
    case ACTIVITY = 'asset_activity';
    case UOM = 'asset_uom';
    case ASSET = 'asset_asset';
    case CONDITION = 'asset_condition';
    case ASSET_REQUEST = 'asset_request';
    case ASSET_TRANSFER = 'asset_transfer';
    case ASSET_DISPOSE = 'asset_dispose';
}
