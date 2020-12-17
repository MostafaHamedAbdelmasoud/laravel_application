<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Department;
use App\Models\Helpers\ExtractImageFromExcelHelper;
use App\Models\Offer;
use App\Models\SubCategory;
use App\Models\Trader;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Excel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Row;

class OffersImport implements ToModel, WithHeadingRow
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
        $this->rows=0;
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
        $city = City::where('name', $row[trans("cruds.offer.fields.city")])->first();
        $trader = Trader::where('name', $row[trans("cruds.offer.fields.trader")])->first();
        $category = Category::where('name', $row[trans("cruds.offer.fields.category")])->first();
        $sub_category = SubCategory::where('name', $row[trans("cruds.offer.fields.sub_category")])->first();

        if (!$city || !$trader || !$category || !$sub_category) {
            throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
        }
        $offer = Offer::firstOrCreate([
            'name' => $row[trans("cruds.offer.fields.name")],
            'show_in_main_page' => $row[trans("cruds.offer.fields.show_in_main_page")],
            'show_in_trader_page' => $row[trans("cruds.offer.fields.show_in_trader_page")],
            'description' => $row[trans('cruds.offer.fields.description')],
            'phone_number' => $row[trans('cruds.offer.fields.phone_number')],
            'location' => $row[trans('cruds.offer.fields.location')],
            'price' => $row[trans('cruds.offer.fields.price')],
            'add_date' => ExtractImageFromExcelHelper::convertToDate($row[trans("cruds.offer.fields.add_date")]),
            'date_end' => ExtractImageFromExcelHelper::convertToDate($row[trans("cruds.offer.fields.date_end")]),
            'city_id' => $city ? $city->id : '',
            'trader_id' => $trader ? $trader->id : '',
            'category_id' => $category ? $category->id : '',
            'sub_category_id' => $sub_category ? $sub_category->id : '',
        ]);
        $this->rows++;

        if ($this->excel_file) {
            ExtractImageFromExcelHelper::importImage($offer, 'images', $this->excel_file, $this->rows);
        }


        return $offer;
    }
}
