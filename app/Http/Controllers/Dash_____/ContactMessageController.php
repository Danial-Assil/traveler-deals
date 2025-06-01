<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Models\ContactMessage;
use App\Utils\PaginateCollection;

class ContactMessageController extends DashController
{
    public function __construct(ContactMessage $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => ['delete'],
        ]);
    }
 
}
