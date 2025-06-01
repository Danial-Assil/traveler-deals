<?php

namespace App\Http\Controllers\Dash;

use App\Http\Requests\Dash\AboutRequest;
use App\Http\Requests\Dash\NewsRequest;
use App\Models\News;

class NewsController extends DashController
{
    public function __construct(News $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => ['create', 'delete', 'edit'],
        ]);
    }
    public function index()
    {
        $items = $this->model->all();

        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }


    public function store(NewsRequest $request)
    {
        $data = $request->all(); 
        $create = $this->model->create($data);

        if ($create) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('dash.create_successfully'),
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dash.fail_create')]);
        }
    }

    public function update(NewsRequest $request,  $id)
    {
        $data = $request->all();
        $item = $this->model->find($id);
   
        $update = $item->update($data);

        if ($update) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('dash.update_successfully'),
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dash.fail_update')]);
        }
    }
}
