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
     */
    public static function importImage($model, $mediaCollection,$spreadsheet, $indx)
    {
        $i = 0;

        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {

            if ($indx-1 != $i ) {
                $i++;
                continue;
            }
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
            $model->addMedia($myFileName)->toMediaCollection($mediaCollection);

            Storage::delete($myFileName);
        }

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
}
