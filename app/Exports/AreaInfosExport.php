<?php

namespace App\Exports;

use App\Models\AreaInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

class AreaInfosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return AreaInfo::orderBy('name', 'asc')->get();
    }

    public function headings(): array
    {
        return ['ID','Area Name','ISO Code', 'Area Prefix','Billing Increments', 'Remarks1','Remarks2','Created At' ,'Updated At']; // Adjust to your columns
    }
}
