<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Category;
use App\Http\Requests\StoreProductTypeRequest;
use Darryldecode\Cart\Validators\Validator;
class ProductTypeController extends Controller
{

    public function index()
    {
        $producttype = ProductType::all();
        return view('admin.pages.producttype.list',compact('producttype'));
    }


    public function create()
    {
        $category = Category::where('status',1)->get();
        return view('admin.pages.producttype.add',compact('category'));
    }


    public function store(StoreProductTypeRequest $request)
    {
        $data =$request->all();
        $data['slug'] = utf8tourl($request->name);
        if(ProductType::create($data)){
            return redirect()->route('producttype.index')->with('thongbao','Thêm thành công loại sản phẩm ');
        } else {
            return back()->with('thongbao','Có lỗi xảy ra xin kiểm tra lại');
        }

    }


    public function show(ProductType $productType)
    {
        //
    }


    public function edit($id)
    {
        $producttype = ProductType::findOrFail($id);
        $category = Category::where('status',1)->get();
        return response()->json(['category'=> $category,'producttype' =>$producttype],200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:2|max:255',
        ],
        [
            'name.required' => 'Tên loại sản phẩm không được để trống',
            'name.min' => 'Tên loại sản phẩm tối thiểu có 2 ký tự ',
            'name.max' => 'Tên loại sản phẩm tối đa có 255 ký tự',
            'name.unique' => 'Tên loại sản phẩm đã tồn tại  ',
        ]
    );

    if($validator->fails()){
        return response()->json(['error' =>'true','message' => $validator->errors()],200);
    }

    $producttype = ProductType::findOrFail($id);

    $data = $request->all();
    $data['slug'] = utf8tourl($request->name);
    $producttype->update($data);
    if($producttype->update($data)){
        // ProductType::all();
    return response()->json(['result' => 'Sửa thành công','category'=>$producttype],200);
    } else {
        return response()->json(['result' => ' Sửa không thành công '],200);
    }
    }

    public function destroy($id)
    {
        $producttype = ProductType::findOrFail($id);
        if($producttype->delete()){
            return response()->json(['result' => 'Xóa thành công '],200);
        } else {
            return response()->json(['result' => ' Xóa không thành công '],200);
        }
    }
}
