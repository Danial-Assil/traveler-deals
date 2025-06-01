<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends DashController
{
    public function __construct(Setting $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => [],
        ]);
    }
    public function index()
    {
        $item = $this->model->first();

        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('item'));
    }

    public function update(SettingRequest $request,  Setting $setting)
    {
        $data = array_filter($request->all());
        if ($request->image) {
            $data['image'] = $this->uploadImage($request->image);
        }
        $update = $setting->update($data);

        if ($update) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('messages.update_successfully'),
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('messages.fail_update')]);
        }
    }
}
