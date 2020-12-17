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


class DepartmentsImport implements ToModel, WithHeadingRow
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
     * DepartmentsImport constructor.
     * @param null $excel_file
     */
    public function __construct($excel_file = null)
    {

        $this->rows = 0;
        $this->excel_file = $excel_file;
    }

    /**
     * @param array $row
     *
     * @return Department
     * @throws ValidationException
     */
    public function model(array $row)
    {


        $city = City::where('name', $row[trans("cruds.department.fields.city")])->first();
        $trader = Trader::where('name', $row[trans("cruds.department.fields.trader")])->first();
        $category = Category::where('name', $row[trans("cruds.department.fields.category")])->first();
        $sub_category = SubCategory::where('name', $row[trans("cruds.department.fields.sub_category")])->first();

        if (!$city || !$trader || !$category || !$sub_category) {
            throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
        }
        $department = Department::firstOrCreate([
            'name' => $row[trans("cruds.department.fields.name")],
            'about' => $row[trans('cruds.department.fields.about')],
            'phone_number' => $row[trans('cruds.department.fields.phone_number')],

            'city_id' => $city ? $city->id : '',
            'trader_id' => $trader ? $trader->id : '',
            'category_id' => $category ? $category->id : '',
            'sub_category_id' => $sub_category ? $sub_category->id : '',
        ]);

        $this->rows++;


        if ($this->excel_file)
            ExtractImageFromExcelHelper::importImage($department, 'logo', $this->excel_file, $this->rows);

        return $department;
    }


}
