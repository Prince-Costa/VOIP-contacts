<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',   
        'background_color',
        'text_color',  
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function domains()
    {
        return $this->belongsToMany(Domain::class);
    }
}
