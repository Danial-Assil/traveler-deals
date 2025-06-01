<?php

namespace App\Http\Controllers\Dash;

use App\Http\Traits\UploadImage;
use App\Models\Order;

class OrderController extends DashController
{
    
    public function __construct(Order $model)
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

    public function destroy($id)
    {
        $item = $this->model->find($id);
        if (count($item->order_items->first()->images)) {
            foreach ($item->order_items->first()->images as $image) {
                if ($image->image != null) {
                    $this->deleteImage($image->image_path);
                    $this->deleteImage($image->image_thumb_path);
                }
            }
        }
        $delete = $item->delete();

        if ($delete) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('dash.delete_successfully'),
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dash.fail_delete')]);
        }
    }
}
