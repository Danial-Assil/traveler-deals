<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\CounterRequest;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends DashController
{
    public function __construct(Counter $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['edit'],
        ]);
    } 
    public function update(CounterRequest $request, $id)
    {
        $item = $this->model->find($id);
        $data = array_filter($request->all()); 
        $update = $item->update($data);  
      
        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully')); 
        } else {
            return $this->returnError(trans('messages.fail_update')); 
        }
    }
}
