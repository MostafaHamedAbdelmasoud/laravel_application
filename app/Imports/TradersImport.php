<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Department;
use App\Models\Helpers\ExtractImageFromExcelHelper;
use App\Models\SubCategory;
use App\Models\Trader;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Excel;
use Illuminate\Validation\ValidationException;

class TradersImport implements ToModel, WithHeadingRow
{
    /**
     * the excel file uploaded
     * @var null
     */
    private $excel_file;

    /**
     * it contains the number of current rows
     * @var int
     */
    private $rows;
    /**
     * @var int
     */
    private $cnt_of_headers_and_rows_filled_with_data;

    /**
     * DepartmentsImport constructor.
     * @param null $excel_file
     */
    public function __construct($excel_file = null)
    {
        $this->rows = 0;
        $this->excel_file = $excel_file;
        if ($this->excel_file) {
            $this->cnt_of_headers_and_rows_filled_with_data = ExtractImageFromExcelHelper::get_header_and_rows_count($excel_file);
        }
    }

    /**
     * @param array $row
     *
     * @return Department
     * @throws ValidationException
     */
    public function model(array $row)
    {
        if ($this->rows == $this->cnt_of_headers_and_rows_filled_with_data-1) {
            return null;
        } // it exceeds the rows that have data

        $trader = Trader::firstOrCreate([
            'activeness' => $row[trans("cruds.trader.fields.activeness")],
            'name' => $row[trans('cruds.trader.fields.name')],
            'phone_number' => $row[trans('cruds.trader.fields.phone_number')],
            'address' => $row[trans('cruds.trader.fields.address')],
            'details' => $row[trans('cruds.trader.fields.details')],
            'facebook_url' => $row[trans('cruds.trader.fields.facebook_url')],
            'whatsapp' => $row[trans('cruds.trader.fields.whatsapp')],

        ]);

        $this->rows++;


        if ($this->excel_file) {
            ExtractImageFromExcelHelper::importImage($trader, 'images', $this->excel_file, $this->rows);
        }

        return $trader;
    }
}
