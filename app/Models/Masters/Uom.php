<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\UomFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keterangan',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_uoms';
    }

    protected static function newFactory(): Factory
    {
        return UomFactory::new();
    }
}
