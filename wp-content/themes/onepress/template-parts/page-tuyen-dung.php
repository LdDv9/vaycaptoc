<?php
/**
 * Template Name: page tuyển dụng
 */
get_header();
global $post;
?>
<link rel="stylesheet" href="<?php echo WP_HOME?>/asset/plugin/datimepicker/bootstrap-datetimepicker.min.css">
<script src="<?php echo WP_HOME?>/asset/plugin/datimepicker/moment.min.js"></script>
<script src="<?php echo WP_HOME?>/asset/plugin/datimepicker/bootstrap-datetimepicker.min.js"></script>
<div class="container">
    <div class="section-content" style="padding: 100px 0 100px">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="form-ung-tuyen">
                    <div class="col-md-6 pull-left">
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Họ tên</span>
                            <input name="name" class="form-control"  aria-describedby="basic-addon1">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon2">Ngày sinh</span>
                            <input name="dob" class="form-control" id="js-datetime-picker"   aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon">Số điện thoại</span>
                            <input id="money" name="phone" type="number" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6 pull-left">
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Email</span>
                            <input name="email" class="form-control" aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Địa chỉ</span>
                            <input name="address" class="form-control"  aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon">Mức lương mong muốn</span>
                            <input id="money" name="money" type="number" class="form-control" >
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="action" value="tuyen_dung">
                        <!--                        <input type="submit" id="register" class="col-md-4 col-m4-push-4 btn-danger btn-lg" value="ĐĂNG KÝ VAY">-->
                        <button style="margin-top: 50px;" type="submit" id="register" class="col-md-4 col-m4-push-4 btn-danger btn-lg">ỨNG TUYỂN
                        </button>

                    </div>
                </form>
            </div>
            <script >
                    jQuery(document).ready(function ($) {
                        $("#form-ung-tuyen").validate({
                            rules : {
                                name : "required",
                                phone  : {
                                    required : true,
                                    number   : true
                                },
                                money : {
                                    required : true,
                                    number : true
                                },
                                address : {
                                    required : true
                                },
                                email : {
                                    email: true,
                                    required : true
                                },
                                dob : {
                                    required: true
                                }

                            },
                            messages : {
                                name : {
                                    required : "Vui lòng nhập họ tên của bạn"
                                },
                                phone : {
                                    required : "Vui lòng nhập số điện thoại",
                                    number   : "Số điện thoại phải là số",
                                },
                                money : {
                                        required : "Vui lòng nhập số mức lương mong muốn",
                                        number   : "Số tiền vay bắt buộc phải là số"
                                },
                                address : {
                                    required : "Vui lòng nhập địa chỉ"
                                },
                                dob : {
                                    required : "Vui lòng nhập ngày sinh"
                                },
                                email : {
                                    required : "Vui lòng nhập địa chỉ email",
                                    email : "Địa chỉ email sai định dạng"
                                }
                            },
                            errorPlacement: function (error, element) {
                                element.attr('data-original-title', error.text())
                                    .attr('data-toggle', 'tooltip')
                                    .attr('data-placement', 'top');
                                $(element).tooltip('show');

                            },
                            unhighlight: function (element) {
                                $(element)
                                    .removeAttr('data-toggle')
                                    .removeAttr('data-original-title')
                                    .removeAttr('data-placement')
                                    .removeClass('error');
                                $(element).unbind("tooltip");
                            },
                            submitHandler : function(){
                                $.ajax({
                                    type: "post",
                                    url : "<?php echo admin_url('admin-ajax.php')?>",
                                    data : $('#form-ung-tuyen').serialize(),
                                    dataType: 'json',
                                    beforeSend: function () {
                                        $('#register').attr('disabled', true).css({'opacity': '0.5'});
                                        swal({
                                            title:'Xử lý',
                                            html:'Đang xử lý',
                                            type:'info'
                                        });
                                        swal.showLoading();
                                    },
                                    success : function(data){
                                        $('#register').attr('disabled', false).css({'opacity': '1'});

                                        console.log(data);
                                        if (data.success === true) {
                                            swal({
                                                title:"Đăng ký thành công",
                                                html:"<p>"+data.data+"</p>",
                                                type: "success"
                                            }).then(function(){
                                                window.location.reload();
                                            });
                                        } else {
                                            swal({
                                                title:"Đăng ký thất bại",
                                                html:"<p>"+data.data+"</p>",
                                                type: "error"
                                            });
                                            $('.tm-submit-btn').attr('disabled','disabled');
                                        }
                                    }
                                });
                                // return false;
                            }
                        });
                    });
                    jQuery('#js-datetime-picker').datetimepicker({
                        format: 'DD/MM/YYYY',
                        locale: 'VN'
                    });

            </script>
        </div>
        <div class="col-md-12" style="margin-top: 30px">
            <?php
                echo apply_filters('content_page',$post->post_content);
            ?>
        </div>
    </div>
</div>

<?php  get_footer() ?>
