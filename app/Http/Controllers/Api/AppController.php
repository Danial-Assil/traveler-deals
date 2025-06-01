<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController as ControllersAppController;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadFile; 
use Exception;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;

class AppController extends ControllersAppController
{
    use ApiResponseTrait, UploadFile;

    protected $user;
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->middleware('auth.jwt');
        $this->user = JWTAuth::user();
    }

 
}
