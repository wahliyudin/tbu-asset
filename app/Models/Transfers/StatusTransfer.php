<?php

namespace App\Models\Transfers;

use App\Enums\Transfers\Transfer\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_transfer_id',
        'status',
        'date'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function assetTransfer()
    {
        $this->belongsTo(AssetTransfer::class);
    }
}
