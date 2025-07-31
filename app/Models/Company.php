<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'domain_name',
        'registered_address',
        'office_address',
        'business_phone',
        'credit_limit',
        'based_on',
        'operating_on',
        'business_type',
        'interconnection_type',
        'agreement_status',
        'usdt_support',
        'remarks1',
        'remarks2',
    ];

    public function basedOnCountry()
    {
        return $this->belongsTo(Country::class, 'based_on');
    }

    public function operatingOnCountry()
    {
        return $this->belongsTo(Country::class, 'operating_on');
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type');
    }

    public function interconnectionType()
    {
        return $this->belongsTo(InterconnectionType::class, 'interconnection_type');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function additionalCompanyNames()
    {
        return $this->hasMany(AdditionalCompanyName::class);
    }

    public function childCompanies()
    {
        return $this->hasMany(CompanyChild::class, 'parent_id');
    }

    public function childTradeCompany()
    {
        return $this->hasMany(TradeReference::class, 'parent_id');
    }

    public function domains()
    {
        return $this->hasMany(CompanyDomain::class, 'company_id');
    }

}
