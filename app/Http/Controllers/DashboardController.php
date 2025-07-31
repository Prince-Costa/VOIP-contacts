<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Domain;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\BusinessType;
use App\Models\InterconnectionType;


class DashboardController extends Controller
{
    public function index()
    {
        $totalCompanies = Company::count();
        $totalUsers = User::count();
        $totalContacts = Contact::count();
        $totalDomains = Domain::count();
        $totlaPrivateDomain = Domain::where('type', 'Private')->count();
        $totlaPublicDomain = Domain::where('type', '!=', 'Private')->count();
        $totalInterconnectionType = InterconnectionType::count();

        $interconnected = InterconnectionType::where('name', 'Interconnected')->value('id');

        if ($interconnected) {
            $totalInterconnected = Company::where('interconnection_type', $interconnected)->count();
        } else {
            $totalInterconnected = 0;
        }

        $totalBusinessType = BusinessType::count();
        $totalCountry= Country::count();
        $dbSize = collect(DB::select('SHOW TABLE STATUS'))
        ->sum(function ($table) {
            return $table->Data_length + $table->Index_length;
        });
    
        $sizeInMB = round($dbSize / 1024 / 1024, 2);
       
        $tableSizes = collect(DB::select('SHOW TABLE STATUS'))
        ->map(function ($table) {
            $size = $table->Data_length + $table->Index_length;
            return [
                'name' => $table->Name,
                'size_in_mb' => round($size / 1024 / 1024, 2),
            ];
        });


        $datas  = [
            'totalCompanies' => $totalCompanies,
            'totalUsers' => $totalUsers,
            'totalContacts' => $totalContacts,
            'totalDomains' => $totalDomains,
            'totlaPrivateDomain' => $totlaPrivateDomain,
            'totlaPublicDomain' => $totlaPublicDomain,
            'totalInterconnectionType' => $totalInterconnectionType,
            'totalBusinessType' => $totalBusinessType,
            'totalCountry' => $totalCountry,
            'dbSize' => $sizeInMB,
            'totalInterconnected' => $totalInterconnected,
        ];
       
        return view('admin.dashboard' , compact('datas','tableSizes'));
    }
}
