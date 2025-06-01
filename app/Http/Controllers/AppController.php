<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppController extends Controller
{
    //
    protected $model;
    protected $request;
    protected $app_folder;
    protected $uploads_folder;
    protected $components_folder;
    protected $layouts_folder;
    protected $includes_folder;
    protected $guard;
    protected $user;
    protected $controller_name;
    protected $module_name;
    protected $module_actions = [];
    protected $module_inputs = [];
    protected $module_columns = [];
    protected $asset_version = 1;

    public function __construct(Model $model = null, Request $request = null)
    {
        $this->model = $model;
        $this->request = $request;
        $this->uploads_folder = 'uploads';
        $this->module_actions = ['delete', 'create', 'active', 'edit', 'show'];
        $this->components_folder = $this->app_folder . 'components';
        $this->includes_folder = $this->app_folder . '.includes';
        $this->layouts_folder = $this->app_folder . '.layouts';
        $this->controller_name = $this->getControllerName();
        $this->module_name =  Str::snake(Str::plural($this->controller_name));


        view()->share([
            'module_name' => $this->module_name,
            'uploads_folder' => $this->uploads_folder,
            'components_folder' => $this->components_folder,
            'includes_folder' => $this->includes_folder,
            'layouts_folder' => $this->layouts_folder,
            'module_actions' => $this->module_actions,
            'website_title' => 'Traverler Deals',
            'page_title' =>  trans($this->module_name . '.module_title'),
            'asset_version' => $this->asset_version,
        ]);
    }


    protected function getControllerName()
    {
        return str_replace('Controller', '', class_basename($this));
    }
}
