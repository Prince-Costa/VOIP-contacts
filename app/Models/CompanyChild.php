<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyChild extends Model
{
    protected $fillable = [
        'parent_id',
        'child_company_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Company::class, 'child_company_id');
    }

    public function company()
    {
        // Returns the parent or child company, whichever exists
        return $this->parent ?? $this->child;
    }
}
