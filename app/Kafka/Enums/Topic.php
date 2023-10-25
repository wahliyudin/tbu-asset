<?php

namespace App\Kafka\Enums;

enum Topic: string
{
    case CATEGORY = 'asset_category';
    case CLUSTER = 'asset_cluster';
    case SUB_CLUSTER = 'asset_sub_cluster';
    case ASSET = 'asset_asset';
}
