<?php

namespace App\Imports;

use App\Models\AreaInfo;
use Maatwebsite\Excel\Concerns\ToModel;

class AreaInfoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AreaInfo([
            'prefix' => $row[0] ?? null,
            'name' => $row[1] ?? null,
            'billing_increments' => $row[2] ?? null,
            'iso_code' => $row[3] ?? null,
            'remarks1' => $row[4] ?? null,
            'remarks2' => $row[5] ?? null,
            // map other columns here
        ]);
    }
}
