<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Image;

trait UploadFile
{

    // ---------------- [ Upload Image ] ----------------
    protected function uploadImage($img = null, $folder_path = null, $key = null)
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

            if ($folder_path) {
                $path = explode('/', $folder_path)[0] !=   $this->uploads_folder ? $this->uploads_folder . '/' . $folder_path : $folder_path;
            } else {
                $path = $this->uploads_folder . '/' . $this->module_name;
            }
            $this->createPathFolders($path);
            $thumb_path = $path . '/thumbs';
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

    // ---------------- [ Delete Image ] ----------------
    public function deleteImage($image_folder, $image_name)
    {
        if (File::exists(public_path($image_folder . '/' . $image_name))) {
            File::delete(public_path($image_folder . '/' . $image_name));
            File::delete(public_path($image_folder . '/thumbs/' . $image_name));
        }
    }

    // ---------------- [ Upload File ] ----------------
    protected function uploadFile($file = null, $folder_path = null, $key = null)
    {
        $file = $file ?? request('file');
        if ($file) {
            //get file extension
            $extension = $file->getClientOriginalExtension();
            //filename to store
            $filename = $this->module_name;
            if ($key) {
                $filename = $this->module_name . '_' . $key;
            }

            $filenametostore = $filename . '_' . time() . '.' . $extension;

            if ($folder_path) {
                $path = explode('/', $folder_path)[0] != $this->uploads_folder ? $this->uploads_folder . '/' :  $folder_path;
            } else {
                $path = $this->uploads_folder . '/' . $this->module_name;
            }
            $this->createPathFolders($path);
            $fl = $file->move(public_path($path), $filenametostore);

            if ($fl) {
                return $filenametostore;
            }
        }
        return false;
    }


    // ---------------- [ Delete File ] ----------------
    public function deleteFile($file_folder, $file_name)
    {
        if (File::exists(public_path($file_folder . '/' . $file_name))) {
            File::delete(public_path($file_folder . '/' . $file_name));
        }
    }


    // ---------------- [ To Create All Folders Of Path In Public ] ----------------
    public function createPathFolders($path)
    {
        if (!file_exists($path)) {
            $folders =  explode('/', $path);
            $current_path = $folders[0];
            if (!file_exists($folders[0])) {
                mkdir(public_path($current_path), 0755);
            }
            foreach ($folders as $key => $name_folder) {
                if ($key == 0)  continue;
                $current_path = $current_path . '/' . $name_folder;
                if (!file_exists($current_path)) {
                    mkdir(public_path($current_path), 0755);
                }
            }
        }
    }

      // ---------------- [ Upload File To Storage ] ----------------
      protected function uploadFileToStorage($file = null, $folder_path = null, $key = null)
      {
          $file = $file ?? request('file');
          if ($file) {
              //get file extension
              $extension = $file->getClientOriginalExtension();
              //filename to store
              $filename = $this->module_name;
              if ($key) {
                  $filename = $this->module_name . '_' . $key;
              }
  
              $filenametostore = $filename . '_' . time() . '.' . $extension;
  
              if ($folder_path) {
                  $path =  $folder_path;
              } else {
                  $path = $this->uploads_folder . '/' . $this->module_name;
              }
  
              Storage::disk('local')->put($path . '/' . $filenametostore, file_get_contents($file));
  
              return $filenametostore;
          }
          return false;
      }
}
