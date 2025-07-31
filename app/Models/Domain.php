<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
    ];    

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
