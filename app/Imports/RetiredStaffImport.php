<?php

namespace App\Imports;

use App\Models\RetiredStaff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class RetiredStaffImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $retiredOn = null;
            if (!empty($row['retired_on'])) {
                try {
                    $date = str_replace('/', '-', trim($row['retired_on']));
                    $retiredOn = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Invalid date format — skip conversion
                    $retiredOn = null;
                }
            }
            $staff = RetiredStaff::create([
                'name_eng' => $row['name_eng'] ?? '',
                'name_mal' => $row['name_mal'] ?? '',
                'retired_as' => $row['retired_as'] ?? '',
                'retired_on' => $retiredOn,
                'address' => $row['address'] ?? '',
                'district' => $row['district'] ?? '',
                'pin' => $row['pin'] ?? '',
                'contact_no' => $row['contact_no'] ?? '',
                'kla_id' => $row['kla_id'] ?? '',
                'mail_id' => $row['mail_id'] ?? '',
            ]);

            // Handle the image import
            if (!empty($row['photo'])) {
                $imageName = trim($row['photo']);
                $imagePath = storage_path('app/public/imports/images/' . $imageName);
                if (file_exists($imagePath)) {
                    $staff
                        ->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }
        }
    }
}
