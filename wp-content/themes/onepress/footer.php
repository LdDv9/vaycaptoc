<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

$hide_footer = false;
$page_id = get_the_ID();

if ( is_page() ){
    $hide_footer = get_post_meta( $page_id, '_hide_footer', true );
}

if ( onepress_is_wc_active() ) {
    if ( is_shop() ) {
        $page_id =  wc_get_page_id('shop');
        $hide_footer = get_post_meta( $page_id, '_hide_footer', true );
    }
}

if ( ! $hide_footer ) {
    ?>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <?php
        /**
         * @since 2.0.0
         * @see onepress_footer_widgets
         * @see onepress_footer_connect
         */
        do_action('onepress_before_site_info');
        $onepress_btt_disable = sanitize_text_field(get_theme_mod('onepress_btt_disable'));

        ?>

        <div class="site-info">
            <div class="container">
                <?php if ($onepress_btt_disable != '1') : ?>
                    <div class="btt">
                        <a class="back-top-top" href="#page" title="<?php echo esc_html__('Back To Top', 'onepress') ?>"><i class="fa fa-angle-double-up wow flash" data-wow-duration="2s"></i></a>
                    </div>
                <?php endif; ?>
                <?php
                /**
                 * hooked onepress_footer_site_info
                 * @see onepress_footer_site_info
                 */
                do_action('onepress_footer_site_info');
                ?>
            </div>
        </div>
        <div id="call">
            <a id="call-a" href="tel:+841628500169" title="liên hệ ngay">
                <img id="img-call" src="/asset/images/call.png" alt="liên hệ ngay" style="height: 100px;position: fixed; right: 5px;bottom: 50px; z-index: 999">
            </a>
        </div>
        <!-- .site-info -->

    </footer><!-- #colophon -->
    <?php
}
/**
 * Hooked: onepress_site_footer
 *
 * @see onepress_site_footer
 */
do_action( 'onepress_site_end' );
?>
</div><!-- #page -->

<?php wp_footer(); ?>
<script src=" <?php echo get_template_directory_uri() ?>/assets/js/plugins.js" > </script>
<!--<script src=" --><?php //echo get_template_directory_uri() ?><!--/assets/js/imagesloaded.js" > </script>-->
<script src="/asset/jq/jquery.validate.min.js"></script>
<script src="/asset/bootstrap/js/bootstrap.min.js"></script>
<script src=" <?php echo get_template_directory_uri() ?>/assets/js/theme.js" > </script>
<script>
    jQuery(document).ready(function ($) {

        $("#form-register").validate({
            rules : {
                name : "required",
                phone  : {
                    required : true,
                    number   : true,
                    minlength : 9,
                },
                cmnd : {
                    required : true,
                    number   : true,
                    minlength : 9,
                    maxlength : 12,
                },
                money : {
                    required : true,
                    number : true,
                    minlength : 8,
                }

            },
            messages : {
                name : {
                    required : "Vui lòng nhập họ tên của bạn"
                },
                phone : {
                    required : "Vui lòng nhập số điện thoại",
                    number   : "Số điện thoại phải là số",
                    minlength : "Số điện thoại quá ngắn"
                },
                cmnd : {
                    required : "Vui lòng nhập số CMND",
                    number   : "Số CMND phải là số",
                    minlength : "Số CMND quá ngắn, yêu cầu phải 9 số",
                    maxlength : "Sô CMND quá dài, yêu cầu phải 9 số"
                },
                money : {
                    required : "Vui lòng nhập số tiền muốn vay",
                    number   : "Số tiền vay bắt buộc phải là số",
                    minlength : "Số tiền vay quá ít"
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
                    data : $('#form-register').serialize(),
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
//                        $('#register').click(function () {
//                            swal({
//                                html:'Đ!t Mẹ Lỗi',
//                                type: 'error'
//                            });
//                            return false;
//                        });
    });
</script>

</body>
</html>
