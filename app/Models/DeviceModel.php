<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
