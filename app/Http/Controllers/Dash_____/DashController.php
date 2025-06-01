<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\AppController;
use App\Http\Traits\JsonResponseTrait;
use App\Http\Traits\UploadFile;  
use App\Utils\PaginateCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DashController extends AppController
{

    use UploadFile, JsonResponseTrait;
    public function __construct(Model $model = null, Request $request = null)
    {
        parent::__construct($model, $request);

        $this->app_folder = 'dash';
        $this->layouts_folder = 'dash';
        $this->guard = 'admin';
        $this->asset_version = '1.00';

        view()->share([
            'guard' => $this->guard,
            'asset_version' => $this->asset_version,
        ]);
    }

    
    public function show($id)
    {
        $item = $this->model->findorfail($id);
        $module_actions = [];
        return view('dash.layouts.app', compact('item', 'module_actions'));
    }

    public function index()
    {
        $items = $this->model->all();
        return view('dash.layouts.app', compact('items'));
    }

    public function getItems(Request $request)
    {
        $items = PaginateCollection::paginate(
            $this->model->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function getItem($id)
    {
        $item = $this->model->findorfail($id);
        return $this->returnData(['item' => $item]);
    }

    public function destroy($id)
    {
        $item = $this->model->find($id);
        if (!$item->deleteable) {
            return $this->returnError('Fail delete because this item have relations with other items');
        }
        if ($item->image) {
            $this->deleteImage($item->image_folder, $item->image);
        }
        if ($item->file) {
            $this->deleteFile($item->file_folder, $item->file);
        }
        $delete = $item->delete();

        if ($delete) {
            return $this->returnSuccess(trans('messages.delete_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_delete'));
        }
    }

    public function toggleActive($id)
    {

        $item = $this->model->find($id);
        // 1 active -- 0 unactive

        $update = $item->update(['status' => $item->status == 0 ? 1 : 0]);

        if ($update) {
            return $this->returnSuccess($item->status ? trans('messages.active_successfully') :  trans('messages.unactive_successfully'));
        } else {
            return $this->returnError(trans('messages.active_fail'));
        }
    }

    public function toggleAtHome($id)
    {

        $item = $this->model->find($id);
        // 1 at home -- 0 not at home 
        $update = $item->update(['at_home' => $item->at_home == 0 ? 1 : 0]);

        if ($update) {
            return $this->returnSuccess($item->at_home ? trans('messages.set_at_home_successfully') :  trans('messages.set_not_at_home_successfully'));
        } else {
            return $this->returnError(trans('messages.set_at_home_fail'));
        }
    }
    

    public function editItemOrder(Request $request, $id)
    {

        $item = $this->model->find($id); 
        $update = $item->update(['item_order' => $request->item_order]);

        if ($update) {
            return $this->returnSuccess(trans('messages.set_order_successfully'));
        } else {
            return $this->returnError(trans('messages.set_order_fail'));
        }
    }
}
