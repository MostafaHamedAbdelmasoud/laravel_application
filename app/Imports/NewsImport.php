<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Department;
use App\Models\Helpers\ExtractImageFromExcelHelper;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsSubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Excel;
use Illuminate\Validation\ValidationException;

class NewsImport implements ToModel, WithHeadingRow
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

        $city = City::where('name', $row[trans("cruds.news.fields.city_name")])->first();
        $news_category = NewsCategory::where('name', $row[trans("cruds.news.fields.news_category_name")])->first();
        $news_sub_category = NewsSubCategory::where('name', $row[trans("cruds.news.fields.news_sub_category_name")])->first();

        if (!$news_category || !$news_sub_category || !$city) {
            throw ValidationException::withMessages(['field_name' => 'القيم ليست صحيحه، برجاء التأكد من الأسماء و القيم المُدخله!']);
        }

        $news = News::firstOrCreate([
            'name' => $row[trans("cruds.news.fields.name")],
            'added_by_admin' => '1',
            'details' => $row[trans('cruds.news.fields.details')],
            'detailed_title' => $row[trans('cruds.news.fields.detailed_title')],
            'phone_number' => $row[trans('cruds.news.fields.phone_number')],
            'approved' => $row[trans('cruds.news.fields.approved')],
            'price' => $row[trans('cruds.news.fields.price')],
            'add_date' => ExtractImageFromExcelHelper::convertToDate($row[trans("cruds.news.fields.add_date")]),
            'city_id' => $city->id,
            'news_category_id' => $news_category->id,
            'news_sub_category_id' => $news_sub_category->id,
        ]);

        $this->rows++;


        if ($this->excel_file) {
            ExtractImageFromExcelHelper::importImage($news, 'image', $this->excel_file, $this->rows);
        }

        return $news;
    }

    /**
     * it returns count of rows
     *
     * @return int
     */
    public function get_header_and_rows_count()
    {
        $objPHPExcel = $this->excel_file;
        $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
        $data = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
        $data = array_map('array_filter', $data);
        return count(array_filter($data));
    }
}
