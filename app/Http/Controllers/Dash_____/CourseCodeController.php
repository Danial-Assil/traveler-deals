<?php

namespace App\Http\Controllers\Dash;
 
use App\Models\CourseCode;

class CourseCodeController extends DashController
{

    public function __construct(CourseCode $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => [], 
        ]);
    }
 

}
