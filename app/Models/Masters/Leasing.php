<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\LeasingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leasing extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_leasings';
    }

    protected static function newFactory(): Factory
    {
        return LeasingFactory::new();
    }
}
