<?php

namespace App\Models\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;

class ExtractImageFromExcelHelper
{
    /**
     * get all images in excel file
     *
     * @param $model
     * @param $mediaCollection
     * @param $spreadsheet
     * @param $indx
     * @param int $variant
     * @param int $product
     */
    public static function importImage($model, $mediaCollection, $spreadsheet, $indx, $variant = 0, $product = 0)
    {
        if ($model->getMedia($mediaCollection)) {
            $model->clearMediaCollection($mediaCollection);
        }

        $i = 0;
        $arr = [];

        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {

            $current_row_coordinates = (substr($drawing->getCoordinates(), 1));

            if ($variant) {
                $variant--;
                continue;
            }
            if (($current_row_coordinates != $indx + 1)) {
                $i++;
                continue;
            }


            /********************** extract part ************************/

            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            }
            fclose($zipReader);
            $extension = $drawing->getExtension();

            /********************** add media ************************/

            $myFileName = uniqid() . '_000_Image_' . ++$i . '.' . $extension;
            file_put_contents($myFileName, $imageContents);
            $arr[] = $myFileName;

            $model->addMedia($myFileName)->toMediaCollection($mediaCollection);

            Storage::delete($myFileName);

            if ($product) break;
        }
        return $model;
    }

    /**
     * it converts dates to be suitable for date column
     *
     * @param $value
     * @return false|string
     */
    public static function convertToDate($value)
    {
        $UNIX_DATE = ($value - 25569) * 86400;
        return gmdate("Y-m-d", $UNIX_DATE);
    }

    /**
     * @param $excel_file
     * @return int
     */
    public static function get_header_and_rows_count($excel_file)
    {
        $objPHPExcel = $excel_file;
        $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
        $data = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
        $data = array_map('array_filter', $data);
        return count(array_filter($data));
    }
}
