<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'asset_name',
        'category',
        'quantity',
        'acquisition_date',
        'status',
        'last_maintenance_date',
        'description',
        'location',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'last_maintenance_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(AssetLog::class);
    }
}
