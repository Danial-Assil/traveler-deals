<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\MenuRequest;
use App\Models\Menu;

class MenuController extends DashController
{
    public function __construct(Menu $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['edit', 'in_nav'],
        ]);
    }
   
    public function update(MenuRequest $request, $id)
    {
        $item = $this->model->find($id);
        $data = array_filter($request->all());
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload);
        }
        $update = $item->update($data); 
        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully')); 
        } else {
            return $this->returnError(trans('messages.fail_update')); 
        }
    }


    public function setInNav($id)
    {

        $item = $this->model->find($id);
        // 1 active -- 0 unactive
        $update = $item->update(['in_nav' => $item->in_nav == 0 ? 1 : 0]);

        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully')); 
        } else {
            return $this->returnError(trans('messages.fail_update')); 
        }
    }
}
