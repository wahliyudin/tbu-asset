<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\UnitFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'prefix',
        'model',
        'type',
        'seri',
        'class',
        'brand',
        'serial_number',
        'spesification',
        'tahun_pembuatan',
        'kelengkapan_tambahan',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_units';
    }

    protected static function newFactory(): Factory
    {
        return UnitFactory::new();
    }
}
