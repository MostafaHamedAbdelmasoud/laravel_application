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

        foreach ($news_media as $news_image) {
            if (!in_array($news_image, $request_images)) {
                //delete it
                Media::where('id', $news_image->id)->delete();
            }
        }

        foreach ($request_images as $request_image) {
            if (!in_array($request_image, $images)) {
                $model->addMedia(storage_path('tmp/uploads/' . $request_image))->toMediaCollection('image');
            }
        }


    }
}
