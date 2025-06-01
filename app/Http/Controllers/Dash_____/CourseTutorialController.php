<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Models\Course;
use App\Models\CourseTutorial;
use Illuminate\Support\Str;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;

class CourseTutorialController extends DashController
{
    public function __construct(CourseTutorial $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'edit', 'active', 'delete'],
        ]);
    }

    public function update(Request $request,  $id)
    {
        $data = $request->all();
        $item = $this->model->find($id);
        $course = Course::find($item->course_id);
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $this->deleteImage($item->image_folder, $item->image);
            $data['image'] = $this->uploadImage($request->imageUpload, $course->image_folder . '/tutorials');
        }
        if ($request->videoUpload  && $request->videoUpload != 'undefined') {
            $this->deleteFile($item->video_folder, $item->video);
            $data['video'] = $this->uploadFileToStorage($request->videoUpload, 'courses/' . $item->course_id . '/tutorials');
        }
        $update = $item->update($data);

        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_update'));
        }
    }

    
    public function getTutorialVideo($id, $filename)
    {
        $path = storage_path('app/courses/' . $id  . '/tutorials/' . $filename);

        // if (!Storage::exists($path)) {
        //     abort(404);
        // }

        return response()->file($path);
    }
}
