<?php

namespace App\Http\Repositories;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
class CategoryRepository{

    public function all()
    {
        $category= Category::all();
        return $category;
    }

    public function create(StoreCategoryRequest $request){
        Category::create([
            'name' => $request->name,
            'slug' => utf8tourl($request->name),
            'status' => $request->status
           ]);

    }
}
 ?>
