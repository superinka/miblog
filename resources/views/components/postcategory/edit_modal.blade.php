<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">{{$title}}</h5>
    </div>
    
    <form action="#" class="form-horizontal">
        <div class="modal-body">
            <div class="form-group">
                <label class="control-label col-sm-12 col-md-3">Danh Mục</label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" placeholder="Tên Danh Mục" id="name" value="<?=$info->name?>" onkeyup="ChangeToSlug();" class="form-control">
                </div>
            </div>
    
            <div class="form-group">
                <label class="control-label col-sm-12 col-md-3">Thuộc</label>
                <div class="col-sm-12 col-md-9">
                    <select class="basic-single select select-fixed-single" id="parent" name="state">
                        <option value="0">Danh mục gốc</option>
                        <?php echo $output2; ?>
                    </select>
                </div>
            </div>
    
            <div class="form-group">
                <label class="control-label col-sm-12 col-md-3">Mô tả</label>
                <div class="col-sm-12 col-md-3">
                    <textarea rows="5" cols="5" class="form-control" id="description" placeholder="Mô tả nhanh"><?=$info->description?></textarea>
                </div>
            </div>
    
            <div class="form-group">
                <label class="control-label col-sm-12 col-md-3">Slug</label>
                <div class="col-sm-12 col-md-3">
                    <input type="text" placeholder="slug" id="slug" name="slug" value="<?=$info->slug?>"class="form-control">
                </div>
            </div>
    
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="styled" id="valid" <?=($info->valid==1)? 'checked="checked"' : "";  ?>>
                    Valid
                </label>
            </div>
        </div>
        <div class="er">
            <div class="alert alert-danger no-border hide">
            </div>
            <div class="alert alert-success no-border hide">
            </div>
        </div>
        <div class="modal-footer">
    
            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            <button type="button" id="add" class="btn btn-primary">Submit</button>
        </div>
    </form>
    
    <script type="text/javascript" src="{{ asset('theme/assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/assets/js/core/libraries/jquery_ui/interactions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/assets/js/plugins/forms/select2/select2.min.js') }}"></script>
    
    <script type="text/javascript">
    $(function() {
    
        // Checkboxes/radios (Uniform)
        // ------------------------------
    
        // Default initialization
        $(".styled, .multiselect-container input").uniform({
            radioClass: 'choice'
        });
    
    
        // Fixed width. Single select
        $('.select-fixed-single').select2({
            minimumResultsForSearch: 2,
            width: 350
        });
        
    });
    
    </script>
    
    <script>
        $(document).ready(function(){
            
        // when click submit
        $('#add').click(function(){
            var id = "<?php echo $info->id ?>";
            var name            = $('#name').val();
            var parent          = $('#parent').val();
            var description     = $('#description').val();
            var slug            = $('#slug').val();
            var valid;
            console.log(parent);
            if ($('#valid').is(":checked"))
                {
                    valid =1;
                }
            else{
                valid =0;
            }
            $.ajax({
                type : "POST",
                dataType : "JSON",
                url: "<?php echo url('admin/postcategory/edit'); ?>",
                data : {
                    id              : id,
                    name            : name,
                    parent          : parent,
                    description     : description,
                    slug            : slug,
                    valid           : valid
                },
                success : function(result)
                {
                    // Có lỗi, tức là key error = 1
                    if (result.hasOwnProperty('error') && result.error == '1'){
                        var html = '';
     
                        // Lặp qua các key và xử lý nối lỗi
                        $.each(result, function(key, item){
                            // Tránh key error ra vì nó là key thông báo trạng thái
                            if (key != 'error'){ 
                                html += '<span  class="text-semibold">'+item+'</span>';
                            }
                        });
                        $('.alert-danger').html(html).removeClass('hide');
                        $('.alert-success').addClass('hide');
                    }
                    else{ // Thành công
                        $('.alert-success').html('Dữ liệu đang được thêm vào!').removeClass('hide');
                        $('.alert-danger').addClass('hide');
     
                        // 4 giay sau sẽ tắt popup
                        setTimeout(function(){
                            $('#actionmodal').modal('hide');
                            // Ẩn thông báo lỗi
                            $('.alert-danger').addClass('hide');
                            $('.alert-success').addClass('hide');
                            location.reload(); // then reload the page.
                        }, 2000);
                    }
                }
            });
        });
    });
    </script>
    
    
    {{--  CHECK SLUG  --}}
    
    <script>
            function ChangeToSlug()
            {
                var title, slug;
        
                //Lấy text từ thẻ input title 
                title = document.getElementById("name").value;
        
                //Đổi chữ hoa thành chữ thường
                slug = title.toLowerCase();
        
                //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                //Xóa các ký tự đặt biệt
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                //Đổi khoảng trắng thành ký tự gạch ngang
                slug = slug.replace(/ /gi, "-");
                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //Xóa các ký tự gạch ngang ở đầu và cuối
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                //In slug ra textbox có id “slug”
                document.getElementById('slug').value = slug;
                //console.log(slug);
        
                var new_slug = document.getElementById('slug').value;
                //console.log(new_slug);
    
            }
        
        
    </script>