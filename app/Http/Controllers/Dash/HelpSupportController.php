<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\AboutRequest;
use App\Models\HelpSupport;
use Illuminate\Http\Request;

class HelpSupportController extends DashController
{
    public function __construct(HelpSupport $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => ['delete'],
        ]);
    }



    public function index()
    {
        $items = $this->model->get();

        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|nullable'
        ]);
        $data = $request->all();
        $item = $this->model->find(1);
        $update = $item->update($data);

        if ($update) {
            session()->flash('success', trans('dashboard.update_successfully'));
            return redirect()->back();
        } else {
            session()->flash('error', trans('dashboard.fail_update'));
            return redirect()->back();
        }
    }
}
