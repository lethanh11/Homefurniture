@extends('admin.layouts.master')

@section('title', 'Thêm Danh Mục Sản Phẩm')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Category</h6>
    </div>
    <div class="row" style="margin: 5px">
        <div class="col-lg-6">
        <form role="form" action="{{route('category.store')}}" method="post">
            @csrf
                <fieldset class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="name" placeholder="Nhập Tên Danh Mục ">
                </fieldset>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="1">Hiển Thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success submit" data-target="#submit">Submit Button</button>
            </form>
        </div>
    </div>
@endsection
