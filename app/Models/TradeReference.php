<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeReference extends Model
{
    protected $table = 'trade_references';

    protected $fillable = [
        'parent_id',
        'reference_company_id',   
    ];

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Company::class, 'reference_company_id');
    }
}
