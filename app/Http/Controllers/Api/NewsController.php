<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;

class NewsController extends AppController
{
    //
    use ApiResponseTrait;
    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $data = [
            'news' =>  News::all(),
        ];

        return $this->returnData($data);
    }
}
