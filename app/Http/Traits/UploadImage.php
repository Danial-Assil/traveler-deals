<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\File;

use Image;

trait UploadImage
{

    // ---------------- [ Upload image ] ----------------
    protected function uploadImage($img = null, $folder = null, $key = null)
    {
        $image = $img ?? request('image');
        if ($image) {
            //get file extension
            $extension = $image->getClientOriginalExtension();
            //filename to store
            $filename = $this->module_name;
            if ($key) {
                $filename = $this->module_name . '_' . $key;
            }

            $filenametostore = $filename . '_' . time() . '.' . $extension;
            if (!file_exists(public_path($this->uploads_folder))) {
                mkdir(public_path($this->uploads_folder), 0755);
            }
            $path = $this->uploads_folder . '/' . $this->module_name;
            if (!file_exists($path)) {
                mkdir(public_path($path), 0755);
            }
            if ($folder) {
                $path = $this->uploads_folder . '/' . $this->module_name . '/' . $folder;
            }
            $thumb_path = $path . '/thumbs';
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0755);
            }
            if (!file_exists(public_path($thumb_path))) {
                mkdir(public_path($thumb_path), 0755);
            }
            $img = $image->move(public_path($path), $filenametostore);

            if ($img) {
                Image::make($path . '/' . $filenametostore)->resize(
                    245,
                    245,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                )->save(public_path($thumb_path) . '/' . $filenametostore);
                return $filenametostore;
            }
        }
        return false;
    }

    // ---------------- [ Delete image ] ----------------
    public function deleteImage($image_path)
    {
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
