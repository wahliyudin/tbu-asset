<?php

namespace App\Kafka\Enums;

enum Topic: string
{
    case CATEGORY = 'asset_category';
    case ASSET = 'asset_asset';
}
