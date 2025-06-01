<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController; 
use App\Http\Requests\Dash\EventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends DashController
{
    public function __construct(Event $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'active', 'edit', 'delete'],
        ]);
    }


    public function store(EventRequest $request)
    {
        $data = $request->all();
        $data['image'] = null; 
        $data['date'] = Carbon::today(); 
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
}
