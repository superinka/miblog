<!-- HTML sourced data -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">{{$title}}</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">
        <a class="openModal" data-toggle="modal" data-target="#actionmodal" data-action="add" data-id="0">
            <button type="button" class="btn bg-teal-400 btn-labeled"><b><i class="icon-add"></i></b> 
                Thêm mới
            </button>
        </a>
    </div>

    <table class="table datatable-html">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Thuộc</th>
                <th>Slug</th>
                <th>Ngày tạo</th>
                <th>Tình trạng</th>
                <th class="text-center">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php                
            foreach ($categories as $key => $value) { 

            ?>
            <tr>
                    <td>
                        <a class="openModal" data-toggle="modal" data-target="#actionmodal" data-action="edit" data-id="<?=$value->id ?>">
                            <?=$value->name?>
                        </a>
                    </td>
                    <td><?=$value->parent_cate?></td>
                    <td><?=$value->slug?></td>
                    <td><a href="#"><?=$value->created_at?></a></td>
                    <td><?= ($value->valid==1) ? '<span class="label label-info">active</span>' : '<span class="label label-danger">inactive</span>' ?></td>
                    <td class="text-center">
                        <a href="#" id="delete" data-id="<?=$value->id ?>"><i class="icon-bin"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- /HTML sourced data -->

<!-- ACTION MODAL -->
<div id="actionmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- /ACTION MODAL -->

<script>
$(document).ready(function(){

    $('.openModal').click(function(){
        var id = $(this).attr('data-id');
        console.log(id);
        var action = $(this).attr('data-action');
        console.log(action);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: '/admin/postcategory/action', // This is the url we gave in the route
            data: {'id' : id, 'action':action}, // a JSON object to send back
            success: function(response){ // What to do if we succeed
                //console.log(response);
                $(".modal-content").html(response); 
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

});
</script>

<script>
$(document).ready(function(){
    $(document).on('click', '#delete', function(e){
        
        var productId = $(this).data('id');
        SwalDelete(productId);
        e.preventDefault();
    });

});

function SwalDelete(productId){
        
        swal({
            title:'Bạn có chắc chắn?',
            text: "Dữ liệu này sẽ bị xóa ngay lập tức!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đúng, Xóa nó!',
            cancelButtonText: 'Bỏ qua',
            showLoaderOnConfirm: true,
                
            preConfirm: function() {
                return new Promise(function(resolve) {
                    //console.log(productId);
                    data = {id:productId};
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/admin/postcategory/destroy",
                        type : "POST",
                        dataType : "JSON",
                        data : data
                    })
                    .done(function(response){
                        swal('Đã xóa!', response.message, response.status);
                    location.reload(); // then reload the page.
                    })
                    .fail(function(){
                        swal('Oops...', 'Có lỗi xảy ra !', 'error');
                    });
                });
            },
            allowOutsideClick: false			  
        });	
        
    }
</script>