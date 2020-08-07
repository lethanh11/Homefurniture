<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{

    public function index()
    {
        $producttype = ProductType::all();
        return view('admin.pages.producttype.list',compact('producttype'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(ProductType $productType)
    {
        //
    }


    public function edit(ProductType $productType)
    {
        //
    }


    public function update(Request $request, ProductType $productType)
    {
        //
    }

    public function destroy(ProductType $productType)
    {
        //
    }
}
