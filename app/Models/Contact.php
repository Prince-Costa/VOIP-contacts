<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email1',
        'email2',
        'phone_number',
        'role',
        'company_id',
        'contact_type_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
}
