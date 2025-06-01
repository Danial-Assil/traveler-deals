<?php

namespace App\Http\Traits\ControlPanel;

use App\Models\Code;
use App\Models\CourseVideo;
use App\Utils\PaginateCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait CourseTrait
{

    public function getVideos(Request $request, $id)
    {
        $items = PaginateCollection::paginate(
            $this->model->find($id)->videos()->orderBy('item_order')->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function storeVideo(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);
        $data['course_id'] = $id;
        $data['created_by'] = Auth::guard($this->guard)->user()->id;
        $data['image'] = null;
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload, 'courses/' . $id . '/videos');
        }
        if ($request->fileUpload  && $request->fileUpload != 'undefined') {
            $data['file'] = $this->uploadFile($request->fileUpload, 'courses/' . $id . '/videos');
        }
        $item = CourseVideo::create($data);

        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }
    }

    public function getCodes(Request $request, $id)
    {
        $items = PaginateCollection::paginate(
            $this->model->find($id)->codes()->with('user')->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function storeCodes(Request $request, $id)
    {
        for ($i = 0; $i < $request->number; $i++) {
            while (true) {
                $code = Str::random(10);
                // check is code valid
                if (Code::whereCode($code)->count() == 0) {
                    break;
                }
            }
            Code::create([
                'code' => $code,
                'course_id' => $id,
            ]);
        }
        return $this->returnSuccess(trans('dash.create_successfully'));
    }
}
