<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Department;
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
    private $excel_file;

    public function __construct($excel_file = null)
    {
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
        $department = Department::create([
            'name' => $row[trans("cruds.department.fields.name")],
            'about' => $row[trans('cruds.department.fields.about')],
            'phone_number' => $row[trans('cruds.department.fields.phone_number')],
            'city_id' => $city ? $city->id : '',
            'trader_id' => $trader ? $trader->id : '',
            'category_id' => $category ? $category->id : '',
            'sub_category_id' => $sub_category ? $sub_category->id : '',
        ]);

        if ($this->excel_file)
            $this->importImage($department, $this->excel_file);

        return $department;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'exists:categories,id',

        ];
    }

    public function importImage($model, $spreadsheet)
    {
        $i = 0;
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG :
                        $extension = 'png';
                        break;
                    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG :
                        $extension = 'jpg';
                        break;
                }
            } else {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }
            $myFileName = uniqid() . '_000_Image_' . ++$i . '.' . $extension;
            file_put_contents($myFileName, $imageContents);
            $model->addMedia($myFileName)->toMediaCollection('logo');

            Storage::delete($myFileName);
        }
    }
}
