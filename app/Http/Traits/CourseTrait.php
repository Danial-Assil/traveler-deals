<?php

namespace App\Http\Traits;

use App\Models\Code;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use JWTAuth;

trait CourseTrait
{
    use JsonResponseTrait;
    public function getItemVideos($slug)
    {
        if ($this->category == 0) {
            $items = $this->model->basic();
        } else {
            $items = $this->model->advance();
        }
        $item = $items->whereSlug($slug)->first();
        if (!in_array($item->id, JWTAuth::user()->enrollments->pluck('course_id')->toArray())) {
            return $this->returnError("You didn't enrolled in this course");
        }
        $item = $items->whereSlug($slug)->with(['subject' => function ($q) {
            return $q->with('university', 'year');
        }])->with('lecturer')->with(['videos' => function ($q) {
            return $q->orderBy('item_order');
        }])->first();

        return $this->returnData([
            'item' => $item,
        ]);
    }

    public function enroll(Request $request)
    {
        if ($this->category == 0) {
            $items = $this->model->basic();
        } else {
            $items = $this->model->advance();
        }
        // get course
        $item = $items->whereSlug($request->slug)->first();
        // check if enroll 
        if (in_array($item->id, JWTAuth::user()->enrollments->pluck('course_id')->toArray())) {
            return $this->returnError(trans('messages.fail_create'));
        }
        // check code if valid
        $code = Code::whereCode($request->code)->first();
        // exists or for this course or is used
        if (
            $code == null // not exists
            || !in_array($request->code, $item->codes->pluck('code')->toArray()) // not for this course
            || $code->is_used == true // this code is used
        ) {
            return $this->returnError(trans('messages.code_not_valid'));
        }
        // code update used
        $code->update(['is_used' => 1, 'used_at' => Carbon::now(), 'user_id' => JWTAuth::user()->id]);
        // create enrollment
        $enroll = Enrollment::create([
            'course_id' => $item->id,
            'user_id' => JWTAuth::user()->id,
            'enrollmentable_id' => $code->id,
            'enrollmentable_type' => Code::class
        ]);

        if ($enroll) {
            return $this->returnSuccess(trans('messages.active_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_active'));
        }
    }

    public function checkEnroll($slug)
    {
        $items = $this->model;
        if ($this->category == 0) {
            $items = $this->model->basic();
        } else {
            $items = $this->model->advance();
        }
        // get course
        $item = $items->whereSlug($slug)->first();
        // check if enroll 
        return $this->returnData([
            'is_enrolled' => in_array($item->id, JWTAuth::user()->enrollments->pluck('course_id')->toArray()),
        ]);
    }
}
