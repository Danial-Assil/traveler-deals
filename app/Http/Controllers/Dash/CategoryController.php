<?php

namespace App\Http\Controllers\Dash;

use App\Http\Requests\Dash\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;

class CategoryController extends DashController
{
    //
    public function __construct(Category $model)
    {
        parent::__construct();
        $this->model = $model;
        return view()->share([
            'module_actions' => [ ],
        ]);
    }

    public function index()
    {
        $items = $this->model->where('status', '!=', null);
        if (request('search_keyword')) {
            $search_keyword = request()->search_keyword;
            $items->when($search_keyword, function ($q) use ($search_keyword) {
                return $q->whereTranslationlike('title', '%' . $search_keyword . '%');
            });
        }
        if (request()->sort) {
            $translationTable = 'category_translations';
            $localeKey = 'locale';
            $table = $this->module_name;
            $keyName = 'id';
            if (request()->sort == 'name_asc') {

                $items->join($translationTable, function (JoinClause $join) use ($translationTable, $localeKey, $table, $keyName) {
                    $join
                        ->on($translationTable . '.category_id', '=', $table . '.' . $keyName)
                        ->where($translationTable . '.' . $localeKey, app()->getLocale());
                })->orderBy($translationTable . '.title', 'asc')
                    ->select($table . '.*')
                    ->with('translations');
            } else if (request()->sort == 'name_desc') {
                $items->join($translationTable, function (JoinClause $join) use ($translationTable, $localeKey, $table, $keyName) {
                    $join
                        ->on($translationTable . '.category_id', '=', $table . '.' . $keyName)
                        ->where($translationTable . '.' . $localeKey, app()->getLocale());
                })->orderBy($translationTable . '.title', 'desc')
                    ->select($table . '.*')
                    ->with('translations');
            } else if (request()->sort == 'oldest') {
                $items->orderBy('id', 'asc');
            } else if (request()->sort == 'latest') {
                $items->orderBy('id', 'desc');
            }
        }
        $items = $items->get();
        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        // return $request->all();
        // $img_name = $this->uploadImage(null, $request->image);
        // if ($img_name) {
        //     $data['image'] = $img_name;
        // }
        $create = Category::create($data);

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

    public function update(CategoryRequest $request,  $id)
    {
        $data = $request->all();
        $item = Category::find($id);
        if ($request->image) {
            if ($item->image) {
                $image_path = "uploads/" . $this->module_name . "/" . $item->image;
                $this->deleteImage($image_path);
            }
            $img_name = $this->uploadImage(null, $request->image);
            if ($img_name) {
                $data['image'] = $img_name;
            }
        }

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
}
