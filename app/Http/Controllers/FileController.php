<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FileController extends Controller
{

    protected function getFile($folder, $id, $file_name)
    {
        $path = storage_path('app/public/' . $folder . '/' . $id . '/' . $file_name);
        return response()->file($path);
    }
}
