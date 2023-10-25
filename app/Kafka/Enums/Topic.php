<?php

namespace App\Kafka\Enums;

enum Topic: string
{
    case CATEGORY = 'asset_category';
    case CLUSTER = 'asset_cluster';
    case ASSET = 'asset_asset';
}
