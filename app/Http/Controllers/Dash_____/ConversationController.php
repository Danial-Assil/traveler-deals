<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Models\About; 

class ConversationController extends DashController
{
    public function __construct(About $model)
    {
        parent::__construct();
        $this->model = $model;
    }
    public function index()
    {
        $items = $this->model->all();
        
        return view($this->app_folder . '.pages.' . $this->module_name . '.index', compact('items'));
    }

 

    
}
