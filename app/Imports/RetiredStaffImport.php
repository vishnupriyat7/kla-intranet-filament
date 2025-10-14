<?php

namespace App\Imports;

use App\Models\RetiredStaff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RetiredStaffImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            RetiredStaff::create([
                'name_eng'   => $row['name_eng'] ?? '',
                'name_mal'   => $row['name_mal'] ?? '',
                'retired_as' => $row['retired_as'] ?? '',
                'retired_on' => $row['retired_on'] ?? null,
                'address'    => $row['address'] ?? '',
                'district'   => $row['district'] ?? '',
                'pin'        => $row['pin'] ?? '',
                'contact_no' => $row['contact_no'] ?? '',
                'kla_id'     => $row['kla_id'] ?? '',
                'mail_id'    => $row['mail_id'] ?? '',
            ]);
        }
    }
}
