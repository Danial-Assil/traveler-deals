<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\AppController; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App; 
use Illuminate\Support\Facades\File;

class DashController extends AppController
{

    public function __construct(Model $model = null, Request $request = null)
    {
        parent::__construct($model, $request);

        $this->app_folder = 'dash';
        $this->guard = 'admin';

        view()->share([
            // 'new_contacts' => count(Contact::where('status', 0)->get()),
            'guard' => $this->guard,
            // 'notifications' =>   $this->user ?  $this->user->notifications->sortByDesc('created_at') : [],
            'notifications' =>     isset($user) ?  $user->notifications->all()  : [],
            'new_notifications' =>  $this->user ?  $this->user->notifications->where('read_at', '==', null) : []
        ]);
    }



    public function welcome()
    {
        return view($this->app_folder . '.welcome');
    }

    public function index()
    {
        $items = $this->model->all();
        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }

    public function show($id)
    {
        $item = $this->model->find($id);
        $module_actions = [];
        $page_title = $item->title;
        return view($this->app_folder . '.pages.' . $this->module_name . '.show', compact('item', 'module_actions', 'page_title'));
    }

    public function create()
    {
        $page_title = trans($this->module_name . '.new_item');
        return view($this->app_folder . '.pages.' . $this->module_name . '.form', compact( 'page_title'));
    }
    
    public function edit($id)
    {
        $item = $this->model->find($id);
        $page_title = $item->title;
        return view($this->app_folder . '.pages.' . $this->module_name . '.form', compact('item',  'page_title'));
    }

    public function destroy($id)
    {
        $item = $this->model->find($id);
        if ($item->image) {
            $image_path = "uploads/" . $this->module_name . "/" . $item->image;
            $this->deleteImage($image_path);
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


    public function change_lang(Request $request)
    {
        $lang =  $request->lang == 'on' ? 'ar' : 'en';
        App::setLocale($lang);
        // Session
        session()->put('locale', $lang);
        return redirect()->back();
    }


    // ---------------- [ Upload image ] ----------------
    // protected function uploadImage($item = null, $img = null)
    // {
    //     $image = $img ?? request('image');
    //     if ($image) {
    //         //get file extension
    //         $extension = $image->getClientOriginalExtension();
    //         //filename to store
    //         $filenametostore = $this->module_name . '_' . time() . '.' . $extension;

    //         if (!file_exists(public_path($this->uploads_folder))) {
    //             mkdir(public_path($this->uploads_folder), 0755);
    //         }

    //         if (!file_exists(public_path($this->uploads_folder . '/' . $this->module_name))) {
    //             mkdir(public_path($this->uploads_folder . '/' . $this->module_name), 0755);
    //         }

    //         $img = $image->move(public_path($this->uploads_folder . '/' . $this->module_name), $filenametostore);

    //         if ($img) {
    //             if ($item) {
    //                 $this->delete_file('public_uploads', $this->module_name . '/' . $item->image);
    //             }
    //             return $filenametostore;
    //         }
    //     }
    //     return false;
    // }

    // // ---------------- [ Delete image ] ----------------
    // public function deleteImage($image_path)
    // {
    //     if (File::exists($image_path)) {
    //         File::delete($image_path);
    //     }
    // }


    public function setActive(Request $request,  $id)
    {

        $item = $this->model->find($id);
        // 1 active -- 0 unactive

        if ($item->status == 0) {
            $item->status = 1;
        } else {
            $item->status = 0;
        }
        $update = $item->update();

        if ($update) {
            return redirect()->back();
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dash.fail_update')]);
        }
    }
}
