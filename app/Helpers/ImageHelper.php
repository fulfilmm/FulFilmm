<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * @param $request
     * @param string $key
     * @param null $old_img_path
     * @param string $disk
     * @return string|null
     */
    public function saveImage($request, $key = 'photo', $old_img_path = null, $disk = 'public')
    {
        if ($request->has($key)) {
            if ($old_img_path != null) {
                $this->delete_img($old_img_path, $disk);
            }
            $photo = $request->file($key);
            return Storage::disk($disk)->put('images', $photo);
        } else {
            return false;
        }
    }

    public function delete_img($old_img_path, $disk = 'public')
    {
        Storage::disk($disk)->delete($old_img_path);
    }
}
