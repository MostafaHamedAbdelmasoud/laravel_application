<?php

namespace App\Imports;

use App\Models\Job;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Job
     */
    public function model(array $row)
    {
        $UNIX_DATE = ($row['add_date'] - 25569) * 86400;
        $date_column = gmdate("Y-m-d", $UNIX_DATE);

        return Job::create([
            'name' => $row['name'],
            'approved' => $row['approved'],
            'whats_app_number' => $row['whats_app_number'],
            'email' => $row['email'],
            'city_id' => $row['city_id'],
            'add_date' => "".$date_column."",
//            'add_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['add_date']),
            'details' => $row['details'],
            'specialization_id' => $row['specialization_id']
        ]);
    }
}
