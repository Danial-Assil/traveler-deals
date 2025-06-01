<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\SocialRequest;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends DashController
{
    public function __construct(Social $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['edit', 'active'],
        ]);
    } 

    public function update(SocialRequest $request, $id)
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
