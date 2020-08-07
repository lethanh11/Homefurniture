$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
    $(`.edit`).click(function(){
        $(`.error`).hide();
        let id = $(this).data('id');
        //Edit
        $.ajax({
            url : 'admin/category/' +id+'/edit',
            dateType : 'json',
            type : 'get',
            success :function($result){
                $(`.name`).val($result.name);
                $(`.title`).text($result.name);
                if($result.status == 1){
                    $(`.hot`).attr('selected','selected');
                } else {
                    $(`.normal`).attr('selected','selected');
                }
            }
        });
        $(`.update`).click(function(){
            let name = $(`.name`).val();
            let status = $(`.status`).val();
            let slug =$(`.slug`).val();
            $.ajax({
                url : 'admin/category/'+id,
                data : {
                    name : name,
                    status : status,
                    slug : slug
                },
                type : 'put',
                dataType : 'json',
                success : function(result){
                    if(result.error == 'true'){
                        $(`.error`).show();
                        $(`.error`).text(result.message.name[0]);

                    }else {
                        toastr.success(result.success, 'Thông Báo', {timeOut: 5000});
                        $('#edit').modal('hide');
                        $('#p'+id).text(result.category['name']);
                        if(status == 1){
                        $('#b'+id).text('Hot');
                        } else {
                            $('#b'+id).text('Normal');
                        }

                        $('#slug'+id).text(result.category['slug']);
                    }
                }
            })
        })
    });
    //Xóa Category
    $(`.delete`).click(function(){
        // $(`.error`).hide();
        let id = $(this).data('id');
        $(`.del`).click(function(){
            $.ajax({
                url : 'admin/category/'+id,
                dataType : 'json',
                method : 'DELETE',
                success : function(result){
                    toastr.success(result.success, 'Thông Báo', {timeOut: 5000});
                    $(`#delete`).modal('hide');
                    $(`button[data-id=${id}]`).closest('tr').hide();
                }
            });
        });
    });
})
