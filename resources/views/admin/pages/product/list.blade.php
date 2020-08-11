@extends('admin.layouts.master')

@section('title', 'Danh Sách Sản Phẩm')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-md-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Mô Tả</th>
                            <th>Ảnh</th>
                            <th>Danh mục sản phẩm</th>
                            <th>Loại Sản Phẩm</th>
                            <th>Số lượng</th>
                            <th>Khuyến mãi</th>
                            <th>Giá</th>
                            <th>Trạng Thái</th>
                            <th>Chỉnh Sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{!! $value->description !!}</td>
                                <td><img src="img/upload/product/{{ $value->image }}" width="100" height="100" alt=""></td>
                                <td>{{ $value->Category->name }}</td>
                                <td>{{ $value->ProductType->name }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ $value->promotional }}%</td>
                                <td>{{ number_format($value->price) }} VNĐ</td>
                                <td>
                                    @if ($value->status == 1)
                                        {{ 'Hiển Thị' }}
                                    @else
                                        {{ 'Ẩn' }}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary editProduct" title="{{ 'Sửa ' . $value->name }}"
                                        data-toggle="modal" data-target="#edit" type="button" data-id="{{ $value->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger deleteProduct" title="{{ 'Xóa ' . $value->name }}"
                                        data-toggle="modal" data-target="#delete" type="button"
                                        data-id="{{ $value->id }}"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Edit Modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa sản phẩm <span class="title"></span> </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" id="updateProduct" method="post" enctype="multipart/form-data">
                                @csrf
                                <fieldset class="form-group">
                                    <label>Tên Sản Phẩm</label>
                                    <input class="form-control name" name="name" placeholder="Nhập Tên loại sản phẩm ">
                                    <div class="alert alert-danger errorName" style="color: red; font-size: 1rem;"></div>
                                </fieldset>
                                <div class="from-group">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" name="quantity" value="1" min='1' class="form-control quantity">
                                    <div class="alert alert-danger errorQuantity" style="color: red; font-size: 1rem;"></div>
                                </div>
                                <div class="from-group">
                                    <label for="price">Đơn Giá</label>
                                    <input type="text" name="price" placeholder="Nhập đơn giá" class="form-control price">
                                    <div class="alert alert-danger errorPrice" style="color: red; font-size: 1rem;"></div>
                                </div>
                                <div class="from-group">
                                    <label for="">Giá khuyến mãi</label>
                                    <input type="text" name="promotional" value="0" placeholder="Nhập giá khuyến mãi nếu có"
                                        class="form-control promotional">
                                        <div class="alert alert-danger errorPromotional" style="color: red; font-size: 1rem;"></div>
                                </div>
                                <img class="img img-thumbnail imageThum" width="100" height="100" lign="center">
                                <div class="from-group">
                                    <label for="">Ảnh</label>
                                    <input type="file" name="image" class="form-control image">
                                    <div class="alert alert-danger errorImage" style="color: red; font-size: 1rem;"></div>
                                </div>
                                <div class="from-group">
                                    <label for="promotional">Mô tả sản phẩm</label>
                                    <textarea name="description" cols="5" rows="5" class="form-control description"></textarea>
                                    <div class="alert alert-danger errorDescription" style="color: red; font-size: 1rem;"></div>
                                </div>
                                <div class="form-group">
                                    <label>Danh Mục Sản Phẩm</label>
                                    <select class="form-control cateProduct" name="Category_id"></select>
                                </div>
                                <div class="form-group">
                                    <label>Loại Sản Phẩm</label>
                                    <select class="form-control proTypeProduct" name="ProductType_id"></select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control status" name="status">
                                        <option value="1" class="hot">Hiển Thị</option>
                                        <option value="0" class="normal">Ẩn</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-success submit" value="Sửa">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có muốn xóa ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 183px;">
                    <button type="button" class="btn btn-success delProduct">Có</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
