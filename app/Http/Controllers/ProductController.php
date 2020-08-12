<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Support\Facades\File;
use Darryldecode\Cart\Validators\Validator;
class ProductController extends Controller
{

    public function index()
    {

        $product = Product::all();
        return view('admin.pages.product.list',compact('product'));
    }


    public function create()
    {
        $category = Category::where('status',1)->get();
        $producttype = ProductType::where('status',1)->get();
        return view('admin.pages.product.add',compact('category','producttype'));
    }


    public function store(StoreProductRequest $request)
    {
        if($request->hasFile('image')){
            $file = $request->image;
            //Lấy tên file
            $file_name = $file->getClientOriginalName();
            //lấy loại file
            $file_type = $file->getMimeType();
            //kích thước file với đơn vị byte
            $file_size = $file->getSize();
           if($file_type == 'image/png' || $file_type =='image/jpg' || $file_type == 'image/jpeg' || $file_type == 'image/gif'){
            if($file_size <= 3145728){
                $file_name = date('DD_mm_yyyy').'_'.rand().'_'.utf8tourl($file_name);
                    if($file->move('img/upload/product',$file_name)){
                        $data = $request->all();
                        $data['slug'] = utf8tourl($request->name);
                        $data['image'] = $file_name;
                        Product::create($data);
                        return redirect()->route('product.index')->with('thongbao','Thêm thành công');
                    }
                }else{
                    return back()->with('error','Bạn không thể upload ảnh có kích thước quá 3MB');
                }
           } else {
            return back()->with('error','Bạn không thể upload ảnh có kích thước quá lớn');
           }
        }else{
            return back()->with('error','Bạn chưa chọn ảnh');
        }
    }


    public function show(Product $product)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::where('status',1)->get();
        $producttype = ProductType::where('status',1)->get();
        $product = Product::findOrFail($id);
        return response()->json(['category'=>$category,'producttype'=>$producttype,'product'=>$product],200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:2',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'promotional' => 'numeric',
            'image' => 'image',
        ],
        [
            'required' => ':attribute không được bỏ trống',
            'min' => ':attribute tối thiểu 2 ký tự',
            'max' => ':attribute tối đa 255 ký tự',
            'numeric' => ':attribute phải là một số',
            'image' => ':attribute không phải là hình ảnh'
        ],
        [
            'name' => 'Tên sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'quantity' => 'Số lượng sản phẩm',
            'price' => 'Đơn giá sản phẩm',
            'promotional' => 'Giá khuyến mãi',
            'image' => 'Ảnh'
        ]
    );
    if($validator->fails()){
        return response()->json(['error'=>'true','message' => $validator->errors()],200);
    }
        $product = Product::findOrFail($id);
        $data = $request->all();
        $data['slug'] = utf8tourl($request->name);
        if($request->hasFile('image')){
            $file = $request->image;
            //Lấy tên file
            $file_name = $file->getClientOriginalName();
            //lấy loại file
            $file_type = $file->getMimeType();
            //kích thước file với đơn vị byte
            $file_size = $file->getSize();
           if($file_type == 'image/png' || $file_type =='image/jpg' || $file_type == 'image/jpeg' || $file_type == 'image/gif'){
            if($file_size <= 3145728){
                $file_name = date('DD_mm_yyyy').'_'.rand().'_'.utf8tourl($file_name);
                    if($file->move('img/upload/product',$file_name)){
                        $data['image'] = $file_name;
                        if(File::exists('img/upload/product'.$product->image)){
                            //Xóa file
                            unlink('img/upload/product'.$product->image);
                        }
                    }
                }else{
                    return response()->json(['error'=>'Kích thước ảnh không quá 3MB'],200);
                }
           } else {
            return response()->json(['error'=>'File bạn chọn không phải là hình ảnh'],200);
           }
        } else {
            $data['image'] = $product->image;
        }
        $product->update($data);
        return response()->json(['result'=>'Sửa thành công'],200);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(File::exists('img/upload/product/'.$product->image)){
            unlink('img/upload/product/'.$product->image);
        }
        $product->delete();
        return response()->json(['result'=>'Xóa thành công'],200);
    }
}
