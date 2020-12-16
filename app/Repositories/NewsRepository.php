<?php


namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Permission;
use Spatie\MediaLibrary\Models\Media;

class NewsRepository
{

    /**
     * it handle updating many images
     *
     * @param $model
     * @param $news_media
     * @param array $request_images
     */
    public function updateMedia($model, $news_media, array $request_images)
    {

        $images = [];
        foreach ($news_media as $image) {
            $images[] = $image->file_name;
        }
        $tmp =[];
        foreach ($news_media as $news_image) {
            if (!in_array($news_image->file_name, $request_images)) {
                //delete it
                $tmp[]= $news_image->file_name;
//                dd($news_image->file_name);
                Media::where('id', $news_image->id)->delete();
            }
        }
//        dd(response()->json([
//            'the deleted ones' => $tmp,
//            'request images' => $request_images,
//            'the original images in news before deleting' => $images,
//        ]));
        foreach ($request_images as $request_image) {
            if (!in_array($request_image, $images)) {
                $model->addMedia(storage_path('tmp/uploads/' . $request_image))->toMediaCollection('image');
            }
        }


    }
}
