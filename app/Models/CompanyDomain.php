<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDomain extends Model
{
    protected $table = 'company_domain';
    protected $fillable = ['company_id', 'domain_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
