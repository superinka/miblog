<!-- Ajax sourced data -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Danh Sách Bài Viết</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">
        <a class="openModal" data-toggle="modal" data-target="#action" data-action="add" data-id="0">
            <button type="button" class="btn bg-teal-400 btn-labeled"><b><i class="icon-add"></i></b> 
                Thêm mới
            </button>
        </a>
    </div>

    <table class="table datatable-ajax">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Location</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
    </table>
</div>
<!-- /ajax sourced data -->

<!-- ACTION MODAL -->
<div id="actionmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- /ACTION MODAL -->

<script>
    $('.openModal').click(function(){
        var id = $(this).attr('data-id');
        var action = $(this).attr('data-action');
        $.ajax({
            type: "POST",
            url: "<?php echo url('admin/post/action'); ?>",
            data: {
            id : id,
            action : action
            },
            success:function(result){
            $(".modal-content").html(result);
        }});
    });
</script>