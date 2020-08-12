<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Cart;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $category = Category::where('status',1)->get();
    //     $producttype = ProductType::where('status',1)->get();
    //     view()->share(['category'=>$category,'producttype' => $producttype]);

    // }

    // public function index(){
    //     $product1 = Product::where('status',1)->where('ProductType_id',1)->get();
    //     $product2 = Product::where('status',1)->where('ProductType_id',3)->get();
    //     return view('client.pages.index',['prosamsung' =>$product1,'proTaiNghe'=>$product2]);
    // }
        public function logout(){
            if(Auth::check()){
                Auth::logout();
                return redirect('/');
            }
        }

    public function updatePass(Request $request){
        $this->validate($request,
        [
            'password' => 'required|min:6|max:255',
            're_password' => 'required|min:6|max:255|same:password'
        ],

        [
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu quá ngắn',
            'passowrd.max' => 'Mật khẩu quá dài',
            're_password' => 'Không được bỏ trống',
            're_password' => 'Nhập không đúng với mật khẩu'
        ]
    );
    $user = User::finOrFail(Auth::user()->id);
    $user->password = Hash::make($request->password);
    $user->save();
    return back();

    }
}
