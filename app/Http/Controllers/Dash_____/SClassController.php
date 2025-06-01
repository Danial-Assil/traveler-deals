<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\EventRequest;
use App\Models\SClass;
use App\Models\Subject;
use App\Models\University;
use App\Models\Year;
use App\Utils\PaginateCollection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class SClassController extends DashController
{
    public function __construct(SClass $model)
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
            $this->model->withCount('subjects', 'users')->latest()->orderBy('item_order')->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
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
        $item = $this->model->findorfail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
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

    public function getSubjects($id)
    {
        $items = PaginateCollection::paginate(
            $this->model->find($id)->subjects()->withCount('courses')->latest()->orderBy('item_order')->get()->map(function ($item) {
                $item['s_class_title'] = $item->s_class->title;
                return $item;
            }),
            5
        );
        return $this->returnData([
            'items' => $items,
        ]);
    }

    public function storeSubject(Request $request, $id)
    {
        $data = $request->all();
        $data['s_class_id'] = $id;
        $data['slug'] = Str::slug($request->title);
        $data['image'] = null;
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload, 'subjects');
        }
        $item = Subject::create($data);
        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }
    }
}
