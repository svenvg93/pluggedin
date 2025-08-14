<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceTypes extends Model
{
    protected $fillable = [
        'name',
        'comment',
        'color',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
