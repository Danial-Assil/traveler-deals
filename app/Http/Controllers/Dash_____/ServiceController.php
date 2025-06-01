<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\ServiceRequest;
use App\Models\Service;
use App\Utils\PaginateCollection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ServiceController extends DashController
{
    public function __construct(Service $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'active', 'edit', 'delete'],
        ]);
    }
  
     
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->title);
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
        $item = $this->model->find($id);
        $data = array_filter($request->all());
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
