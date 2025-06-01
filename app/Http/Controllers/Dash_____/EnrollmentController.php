<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\ClientRequest;
use App\Models\Enrollment;
use App\Utils\PaginateCollection;
use Illuminate\Http\Request;

class EnrollmentController extends DashController
{
    public function __construct(Enrollment $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['create', 'edit', 'active', 'delete'],
        ]);
    }

    public function getItems(Request $request)
    {
        $items = PaginateCollection::paginate(
            $this->model->with('user', 'course')->latest()->get(),
            $request->per_page
        );
        return $this->returnData($items);
    }
}
