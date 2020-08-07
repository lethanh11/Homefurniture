<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Darryldecode\Cart\Validators\Validator;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $category= $this->categoryRepository->all();
        //
        return view('admin.pages.category.list',compact('category'));
    }


    public function create()
    {
        return view('admin.pages.category.add');
    }

    public function store(StoreCategoryRequest $request)
    {

         $this->categoryRepository->create($request);

       return redirect()->route('category.index');
    }

    public function show($id)
    {

    }


    public function edit($id)
    {
        $category = $this->categoryRepository->edit($id);

        return response()->json($category,200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:2|max:255'
        ],
        [
            'required' => 'Tên danh mục sản phẩm không được để trống',
            'min' => 'Tên danh mục sản phẩm phải đủ từ 2-255 ký tự',
            'max' => 'Tên danh mục sản phẩm phải đủ từ 2-255 ký tự',
        ]
    );
    if($validator->fails()){
        return response()->json(['error' => 'true','message' => $validator->errors()], 200);
    }
        $category = Category::findOrFail($id);
        $category->update(
        [
        'name' => $request->name,
        'slug' => utf8tourl($request->name),
        'status' => $request->status
        ]
        );
        return response()->json(['success'=>'Sửa thành công','category'=>$category]);

    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
         $category->delete();
        return response()->json(['success'=>'Xóa thành công']);

    }
}
