// const { result } = require("lodash");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $(`.edit`).click(function () {
        $(`.error`).hide();
        let id = $(this).data('id');
        //Edit
        $.ajax({
            url: 'admin/category/' + id + '/edit',
            dateType: 'json',
            type: 'get',
            success: function ($result) {
                $(`.name`).val($result.name);
                $(`.title`).text($result.name);
                if ($result.status == 1) {
                    $(`.hot`).attr('selected', 'selected');
                } else {
                    $(`.normal`).attr('selected', 'selected');
                }
            }
        });
        $(`.update`).click(function () {
            let name = $(`.name`).val();
            let status = $(`.status`).val();
            let slug = $(`.slug`).val();
            $.ajax({
                url: 'admin/category/' + id,
                data: {
                    name: name,
                    status: status,
                    slug: slug
                },
                type: 'put',
                dataType: 'json',
                success: function (result) {
                    if (result.error == 'true') {
                        $(`.error`).show();
                        $(`.error`).text(result.message.name[0]);

                    } else {
                        toastr.success(result.success, 'Thông Báo', { timeOut: 5000 });
                        $('#edit').modal('hide');
                        $('#p' + id).text(result.category['name']);
                        if (status == 1) {
                            $('#b' + id).text('Hiển Thị');
                        } else {
                            $('#b' + id).text('Ẩn');
                        }

                        $('#slug' + id).text(result.category['slug']);
                    }
                }
            })
        })
    });
    //Xóa Category
    $(`.delete`).click(function () {
        // $(`.error`).hide();
        let id = $(this).data('id');
        $(`.del`).click(function () {
            $.ajax({
                url: 'admin/category/' + id,
                dataType: 'json',
                method: 'DELETE',
                success: function (result) {
                    toastr.success(result.success, 'Thông Báo', { timeOut: 5000 });
                    $(`#delete`).modal('hide');
                    $(`button[data-id=${id}]`).closest('tr').hide();
                }
            });
        });
    });

    //Edit producttype
    $(`.editProducttype`).click(function () {
        $(`.error`).hide();
        let id = $(this).data('id');
        // console.log(id);
        $.ajax({
            url: 'admin/producttype/' + id + '/edit',
            dataType: 'json',
            type: "get",
            success: function (result) {
                $(`.name`).val(result.producttype.name);
                var html = '';
                $.each(result.category, function (key, value) {

                    if (value['id'] == result.producttype.Category_id) {
                        html += '<option value=' + value['id'] + ' selected>';
                        html += value['name'];
                        html += '</option>';
                    } else {
                        html += '<option value=' + value['id'] + '>';
                        html += value['name'];
                        html += '</option>';
                    }

                });
                $(`.Category_id`).html(html);
                if (result.producttype.status == 1) {
                    $(`.hot`).attr('selected', 'selected');
                } else {
                    $(`.normal`).attr('selected', 'selected');
                }
            }
        });
        $(`.updateProductType`).click(function () {
            let Category_id = $(`.Category_id`).val();
            let name = $(`.name`).val();
            let status = $(`.status`).val();
            let slug = $(`.slug`).val();
            $.ajax({
                url: 'admin/producttype/' + id,
                dataType: 'json',
                data: {
                    Category_id: Category_id,
                    name: name,
                    status: status,
                    slug: slug
                },
                type: 'put',
                success: function (data) {
                    if (data.error == 'true') {
                        $(`.error`).show();
                        $(`.error`).text(data.message.name[0]);

                    } else {
                        toastr.success(data.result, 'Thông Báo', { timeOut: 5000 });
                        $('#edit').modal('hide');
                        $('#ploai' + id).text(data.category['name']);
                        if (status == 1) {
                            $('#bloai' + id).text('Hiển Thị');
                        } else {
                            $('#bloai' + id).text('Ẩn');
                        }
                        $('#slugloai' + id).text(data.category['slug']);
                        $.each(data.category, function (i, v) {
                            if (Category_id == v.id) {
                                $(`#loai${id}`).html(v.name);
                            }
                        });
                    }
                }
            });
        });
    });
    $(`.deleteProducttype`).click(function () {
        let id = $(this).data('id');
        $(`.delProductType`).click(function () {
            $.ajax({
                url: 'admin/producttype/' + id,
                dataType: 'json',
                type: 'delete',
                success: function (data) {
                    toastr.success(data.result, 'Thông Báo', { timeOut: 5000 });
                    $('#delete ').modal('hide');
                    $(`button[data-id=${id}]`).closest('tr').hide();
                }
            });
        });
    });
    $(`.cateProduct`).change(function () {
        let idCate = $(this).val();
        $.ajax({
            url: 'getproducttype',
            data: {
                idCate: idCate,
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
                let html = '';
                $.each(data, function (key, value) {
                    html += '<option value=' + value['Category_id'] + '>';
                    html += value['name'];
                    html += '</option>';
                });
                $(`.proTypeProduct`).html(html);
            }
        });
    });
    //Edit sản phẩm
    $(`.editProduct`).click(function () {
        $(`.errorName`).hide();
        $(`.errorQuantity`).hide();
        $(`.errorPrice`).hide();
        $(`.errorPromotional`).hide();
        $(`.errorImage`).hide();
        $(`.errorDescription`).hide();
        let id = $(this).data('id');
        $.ajax({
            url: 'admin/product/' + id + '/edit',
            dataType: 'json',
            type: 'get',
            success: function (data) {
                $(`.name`).val(data.product.name);
                $(`.quantity`).val(data.product.quantity);
                $(`.price`).val(data.product.price);
                $(`.promotional`).val(data.product.promotional);
                $(`.imageThum`).attr('src', 'img/upload/product/' + data.product.image);
                if (data.product.status == 1) {
                    $(`.hot`).attr('selected', 'selected');
                } else {
                    $(`.normal`).attr('selected', 'selected');
                }
                $(`.description`).val(data.product.description);
                let html = '';
                $.each(data.category, function (key, value) {
                    html += '<option value="' + value['id'] + '"class="category"' + key + '>';
                    html += value['name'];
                    html += '</option>';
                    if (data.product.Category_id == value['id']) {
                        $('category' + key).attr('selected', 'selected');
                    }
                });
                $(`.cateProduct`).html(html);
                let html2 = '';
                $.each(data.producttype, function (key, value) {
                    html2 += '<option value="' + value['id'] + '"class="producttype"' + key + '>';
                    html2 += value['name'];
                    html2 += '</option>';
                    if (data.product.ProductType_id == value['id']) {
                        $('producttype' + key).attr('selected', 'selected');
                    }
                });
                $(`.proTypeProduct`).html(html2);
            }
        });
        $(`#updateProduct`).on('submit',function(event){
            event.preventDefault();
            $.ajax({
                url : 'admin/updatePro/'+id,
                data : new FormData(this),
                contentType : false,
                processData : false,
                cache : false,
                type : 'post',
                success : function(data){
                    if(data.error== 'true'){
                        if(data.message.image){
                            $(`.errorImage`).show();
                            $(`.errorImage`).text(data.message.image[0]);
                        }
                        if(data.message.name){
                            $(`.errorName`).show();
                            $(`.errorName`).text(data.message.name[0]);
                        }
                        if(data.message.quantity){
                            $(`.errorQuantity`).show();
                            $(`.errorQuantity`).text(data.message.quantity[0]);
                        }
                        if(data.message.price){
                            $(`.errorPrice`).show();
                            $(`.errorPrice`).text(data.message.price[0]);
                        }
                        if(data.message.promotional){
                            $(`.errorPromotional`).show();
                            $(`.errorPromotional`).text(data.message.promotional[0]);
                        }
                        if(data.message.description){
                            $(`.errorDescription`).show();
                            $(`.errorDescription`).text(data.message.description[0]);
                        }
                    } else {
                        toastr.success(data.result, 'Thông Báo', { timeOut: 5000 });
                        $('#edit').modal('hide');
                        $('#ploai' + id).text(data.category['name']);
                        if (status == 1) {
                            $('#bloai' + id).text('Hiển Thị');
                        } else {
                            $('#bloai' + id).text('Ẩn');
                        }
                        $('#slugloai' + id).text(data.category['slug']);
                        $.each(data.category, function (i, v) {
                            if (Category_id == v.id) {
                                $(`#loai${id}`).html(v.name);
                            }
                        });
                    }
                }
            });
        });
    });


    // delete sản phẩm
    $(`.deleteProduct`).click(function () {
        let id = $(this).data('id');
        $(`.delProduct`).click(function () {
            $.ajax({
                url: 'admin/product/' + id,
                type: 'delete',
                dataType: 'json',
                success: function (data) {
                    toastr.success(data.result, 'Thông Báo', { timeOut: 5000 });
                    $('#delete ').modal('hide');
                    $(`button[data-id=${id}]`).closest('tr').hide();
                }
            });
        });
    });
});
