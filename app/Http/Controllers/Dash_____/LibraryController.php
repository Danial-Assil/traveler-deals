<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\AboutRequest;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LibraryController extends DashController
{
    public function __construct(Library $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['edit'],
        ]);
    } 

    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['image'] = null;   
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload);
        }  
        $item = $this->model->create($data);

        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }
    }

    public function update(Request $request, $id)
    {
        $data = array_filter($request->all());
        $item = $this->model->find($id); 
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $this->deleteImage($item->image_folder, $item->image);
            $data['image'] = $this->uploadImage($request->imageUpload);
        }
        $data['slug'] = Str::slug($request->title);
        $update = $item->update($data);
      
        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully')); 
        } else {
            return $this->returnError(trans('messages.fail_update')); 
        }
    }
}
