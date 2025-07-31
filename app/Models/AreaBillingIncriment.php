<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaBillingIncriment extends Model
{
    protected $fillable = [
        'destination_name',
        'breakouts',
        'billing_incriment',
        'refer',
    ];

}
