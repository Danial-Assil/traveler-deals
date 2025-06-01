<?php

namespace App\Http\Controllers\Dash;

use App\Http\Requests\Dash\AboutRequest;
use App\Models\Deal;

class DealController extends DashController
{
    public function __construct(Deal $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => ['delete', 'show'],
        ]);
    }
    public function index()
    {
        $items = $this->model->all();

        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }
}
