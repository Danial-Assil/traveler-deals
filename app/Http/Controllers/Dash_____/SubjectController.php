<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends DashController
{
    public function __construct(Subject $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['edit'],
        ]);
    }

    public function getAll()
    {
        $items =  $this->model->all();
        return $this->returnData(['items' => $items]);
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
        $item = $this->model->find($id);
        $data = array_filter($request->all());
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $this->deleteImage($item->image_folder, $item->image);
            $data['image'] = $this->uploadImage($request->imageUpload);
        }
        $update = $item->update($data);

        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_update'));
        }
    }
}
