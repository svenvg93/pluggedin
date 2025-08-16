<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceModel extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'vendor',
        'color',
        'comment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class, 'type_id');
    }

    public function deviceCounts(): HasMany
    {
        return $this->hasMany(DeviceCount::class, 'model_id');
    }
}
