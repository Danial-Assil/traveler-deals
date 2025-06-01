<?php

namespace App\Http\Controllers\Dash;

use App\Http\Requests\Dash\UserRequest;
use App\Models\User;
use App\Models\UserAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;

class UserController extends DashController
{

    public function __construct(User $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => ['show', 'delete', 'edit'],
        ]);
    }

    public function index()
    {
        $items = $this->model->withCount('trips', 'orders')->where('status', '!=', null);

        $items = $items->get();
        // return $items;
        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }


    public function store(UserRequest $request)
    {
        $data = $request->all();
        // return $request->all();
        $img_name = $this->uploadImage(null, $request->image);
        if ($img_name) {
            $data['image'] = $img_name;
        }
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

    public function resetPassword(Request $request,  $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|max:10',
        ]);

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


    public function setActive(Request $request,  $id)
    {

        $data = $request->all();
        $item = $this->model->find($id);
        // 1 active -- 0 unactive

        if ($request->active == 'on') {
            $item->status = 1;
        } else {
            $item->status = 0;
        }
        $update = $item->update();

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

    public function update(Request $request,  $id)
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

    public function destroy($id)
    {
        $item = $this->model->find($id);
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


    public function acceptAttach(Request $request)
    {
        $attach = UserAttachment::find($request->id);
        if ($attach->type == 'id') {
            $user = $attach->user()->update(['id_card' => $attach->file]);
        } else {
            $user = $attach->user()->update(['passport' => $attach->file]);
        }
        $attach->update([
            'verified_at' => Carbon::now(),
            'is_verified' => 1,
            'replyed_at' => Carbon::now(),
        ]);
        return $this->returnSuccess(trans('dash.accepted_successfully'));
    }
    public function rejectAttach(Request $request)
    {
        $attach = UserAttachment::find($request->id);
        $attach->update([
            'reply_txt' => $request->reply_txt,
            'replyed_at' => Carbon::now(),
        ]);
        return $this->returnSuccess(trans('dash.accepted_successfully'));
    }
}
