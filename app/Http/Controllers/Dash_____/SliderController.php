<?php

namespace App\Http\Controllers\Dash;

use App\Http\Requests\Dash\SliderRequest;
use App\Models\Slider;
use Illuminate\Support\Str;
use App\Utils\PaginateCollection;

class SliderController extends DashController
{

    public function __construct(Slider $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => [],
        ]);
    }

    
    public function store(SliderRequest $request)
    {
        $data = $request->all();
        $data['image'] = null;
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload);
        } 
        $data['slug'] = Str::slug($request->title);
        $item = $this->model->create($data);

        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }
    }

    public function update(SliderRequest $request,  $id)
    {
        $data = $request->all();
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
