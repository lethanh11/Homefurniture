@extends('admin.layouts.master')

@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm Sản Phẩm</h6>
        </div>
        <div class="row" style="margin: 5px">
            <div class="col-lg-6">
                <form role="form" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="form-group">
                        <label>Tên Sản Phẩm</label>
                        <input class="form-control" name="name" placeholder="Nhập Tên loại sản phẩm ">
                        @if ($errors->has('name'))
                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </fieldset>
                    <div class="from-group">
                        <label for="quantity">Số lượng</label>
                        <input type="number" name="quantity" value="1" min='1' class="form-control">
                        @if ($errors->has('quantity'))
                            <div class="alert alert-danger">{{ $errors->first('quantity') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="price">Đơn Giá</label>
                        <input type="text" name="price" placeholder="Nhập đơn giá" class="form-control">
                        @if ($errors->has('price'))
                            <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="">Giá khuyến mãi</label>
                        <input type="text" name="promotional" value="0" placeholder="Nhập giá khuyến mãi nếu có"
                            class="form-control">
                        @if ($errors->has('promotional'))
                            <div class="alert alert-danger">{{ $errors->first('promotional') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="">Ảnh</label>
                        <input type="file" name="image" class="form-control">
                        @if ($errors->has('image'))
                            <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="promotional">Mô tả sản phẩm</label>
                        <textarea name="description"  cols="5" rows="5" class="form-control"></textarea>
                        @if ($errors->has('description'))
                            <div class="alert alert-danger">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Danh Mục Sản Phẩm</label>
                        <select class="form-control cateProduct" name="Category_id">
                            @foreach ($category as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại Sản Phẩm</label>
                        <select class="form-control proTypeProduct" name="ProductType_id">
                            @foreach ($producttype as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Hiển Thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success submit" data-target="#submit">Thêm</button>
                </form>
            </div>
        </div>
    @endsection
