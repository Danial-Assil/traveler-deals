<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Traits\ControlPanel\CourseTrait;
use App\Models\Course;
use App\Models\CourseCode;
use App\Models\CourseTutorial;
use App\Models\Library;
use App\Models\SClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Utils\PaginateCollection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CourseController extends DashController
{
    use CourseTrait;
    public function __construct(Course $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'active', 'edit', 'delete'],
        ]);
    }


    public function getItems(Request $request)
    {
        $items = PaginateCollection::paginate(
            $this->model->withCount('tutorials', 'codes', 'ratings')
                ->latest()->get()->map(function ($item) {
                    $item['teacher_name'] = $item->teacher->name;
                    $item['subject_title'] = $item->subject->title;
                    $item['ratings_avg'] = $item->ratings_count > 1 ? number_format($item->ratings->sum('pivot.rating') / $item->ratings_count, 1) : 0;
                    return $item;
                }),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function getItem($id)
    {
        $item = $this->model->findorfail($id);
        $item['s_class_id'] = $item->subject->s_class_id;
        return $this->returnData([
            'item' => $item,
            'teachers' => Teacher::all(),
            's_classes' => SClass::with('subjects')->get(),
            'subjects' => Subject::with('s_class')->get(),
        ]);
    }


    public function getNeeds()
    {
        return $this->returnData([
            's_classes' => SClass::with('subjects')->get(),
            'teachers' => Teacher::all(),
            'subjects' => Subject::with('s_class')->get(),
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['image'] = null;
        $data['date'] = Carbon::today();
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);
        $item = $this->model->create($data);
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload, $item->image_folder);
        }
        $item->update(['image' => $data['image']]);
        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }
    }

    public function update(Request $request, $id)
    {
        $item = $this->model->findorfail($id);
        $data = $request->all();
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $this->deleteImage($item->image_folder, $item->image);
            $data['image'] = $this->uploadImage($request->imageUpload, $item->image_folder);
        }
        $update = $item->update($data);
        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_update'));
        }
    }

    public function getCodes(Request $request, $id)
    {
        $all_items = $this->model->find($id)->codes()->latest()->with('library')->get();
        if ($request['filter_code'] && $request['filter_code'] != 'undefined') {
            if ($request['filter_code']) {
                $all_items = $all_items->where('code', $request['filter_code']);
            }
        }
        if ($request['filter_library_id'] && $request['filter_library_id'] != 'undefined') {
            if ($request['filter_library_id']) {
                $all_items = $all_items->where('library_id', $request['filter_library_id']);
            }
        }
        if ($request['filter_is_used'] && $request['filter_is_used'] != 'undefined') {
            if ($request['filter_is_used']) {
                $all_items = $all_items->where('is_used', $request['filter_is_used']);
            }
        }
        $items = PaginateCollection::paginate($all_items, $request->per_page);
        return $this->returnData([
            'items' => $items,
            'libraries' => Library::all()
        ]);
    }

    public function storeCodes(Request $request, $id)
    {
        for ($i = 0; $i < $request->number; $i++) {
            while (true) {
                $code = Str::random(10);
                // check is code valid
                if (CourseCode::whereCode($code)->count() == 0) {
                    break;
                }
            }
            CourseCode::create([
                'code' => $code,
                'library_id' => $request->library_id != 'undefined' ?   $request->library_id : null,
                'course_id' => $id,
            ]);
        }
        return $this->returnSuccess(trans('messages.create_successfully'));
    }

    public function getTutorials(Request $request, $id)
    {

        $items =  PaginateCollection::paginate(
            $this->model->find($id)->tutorials()->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }

    public function storeTutorial(Request $request, $id)
    {
        $data = $request->all();
        $course = Course::find($id);
        $data['course_id'] = $id;
        $data['image'] = null;
        if ($request->imageUpload  && $request->imageUpload != 'undefined') {
            $data['image'] = $this->uploadImage($request->imageUpload, $course->image_folder  . '/tutorials');
        }
        if ($request->videoUpload  && $request->videoUpload != 'undefined') {
            set_time_limit(6400);
            ini_set('memory_limit', -1);
            ini_set('max_execution_time', -1);
            ini_set('post_max_size', '1024M');
            ini_set('upload_max_filesize', '1024M');
            ini_set('max_input_time',  3600);

            $data['video'] = $this->uploadFileToStorage($request->videoUpload, 'courses/' . $id . '/tutorials/');
        }
        $item = CourseTutorial::create($data);

        if ($item) {
            return $this->returnSuccess(trans('messages.create_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_create'));
        }

        return $this->returnSuccess(trans('messages.create_successfully'));
    }


    public function exportCodes(Request $request, $id)
    {
        $course =  $this->model->find($id);
        $all_codes = $course->codes;
        if ($request['filter_code'] && $request['filter_code'] != 'undefined') {
            if ($request['filter_code']) {
                $all_codes = $all_codes->where('code', $request['filter_code']);
            }
        }
        if ($request['filter_library_id'] && $request['filter_library_id'] != 'undefined') {
            if ($request['filter_library_id']) {
                $all_codes = $all_codes->where('library_id', $request['filter_library_id']);
            }
        }
        $file_name = $course->title . '-' . Carbon::today()->format('Y-m-d');

        $pdf = PDF::loadView('dash.exports.codes', ['codes' =>  $all_codes, 'course' => $course]);
        $pdf->setPaper('a4', 'portrait');
        return $this->returnData([
            'file_name' => $file_name,
            'file' => base64_encode($pdf->output())

        ]);
    }
}
