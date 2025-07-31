<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
