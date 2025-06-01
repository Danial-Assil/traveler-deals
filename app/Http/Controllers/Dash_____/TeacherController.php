<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Models\Teacher;
use App\Utils\PaginateCollection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TeacherController extends DashController
{
    public function __construct(Teacher $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'active', 'edit', 'delete'],
        ]);
    }

    public function getItems(Request $request)
    {
        $items = PaginateCollection::paginate(
            $this->model->withCount('courses')->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
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
        $data['slug'] = Str::slug($request->title);
        if ($request->password && $request->password != 'undefined') {
            $data['password'] = bcrypt($request->password);
        }
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
        $item = $this->model->findorfail($id);
        $data = $request->all();
        if ($request->password && $request->password != 'undefined') {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->imageUpload && $request->imageUpload != 'undefined') {
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
