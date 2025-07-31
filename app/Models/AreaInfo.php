<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaInfo extends Model
{
    protected $fillable = [
        'name',
        'prefix',
        'iso_code',
        'billing_increments',
        'remarks1',
        'remarks2',
    ];
}
