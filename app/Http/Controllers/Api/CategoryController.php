<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends AppController
{
    //
    use ApiResponseTrait;
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        $categories = Category::all();
        $items = [];
        foreach ($categories as $category) {
            $item['id'] = $category->id;
            $item['en_title'] = $category->translations[0]->title;
            $item['ar_title'] = $category->translations[1]->title;
            array_push($items, $item);
        }

        $data = [
            'categories' => $items,
            'document_verified' => Auth::user()->document_verified
        ];

        return $this->returnData($data);
    }
}
