<?php
$id       = get_theme_mod( 'onepress_features_id', esc_html__('features', 'onepress') );
$disable  = get_theme_mod( 'onepress_features_disable' ) == 1 ? true : false;
$title    = get_theme_mod( 'onepress_features_title', esc_html__('Features', 'onepress' ));
$subtitle = get_theme_mod( 'onepress_features_subtitle', esc_html__('Why choose Us', 'onepress' ));
if ( onepress_is_selective_refresh() ) {
    $disable = false;
}
$data  = onepress_get_features_data();
if ( !$disable && !empty( $data ) ) {
    $desc = get_theme_mod( 'onepress_features_desc' );
?>
<?php if ( ! onepress_is_selective_refresh() ){ ?>
<section id="<?php if ( $id != '') { echo esc_attr( $id ); } ?>" <?php do_action('onepress_section_atts', 'features'); ?>
         class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-features section-padding section-meta onepage-section', 'features')); ?>">
<?php } ?>
    <?php do_action('onepress_section_before_inner', 'features'); ?>
    <div class="<?php echo esc_attr( apply_filters( 'onepress_section_container_class', 'container', 'features' ) ); ?>">
        <?php if ( $title ||  $subtitle || $desc ){ ?>
        <div class="section-title-area">
            <?php if ($subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($subtitle) . '</h5>'; ?>
            <?php if ($title != '') echo '<h2 class="section-title">' . esc_html($title) . '</h2>'; ?>
            <?php if ( $desc ) {
                echo '<div class="section-desc">' . apply_filters( 'onepress_the_content', wp_kses_post( $desc ) ) . '</div>';
            } ?>
        </div>
        <?php } ?>
        <div class="section-content">
            <div class="row wow slideInUp">
                <form id="form-register" class="bs-example bs-example-form col-md-12" data-example-id="simple-input-groups">
                    <div class="col-md-6 pull-left">
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Họ tên</span>
                            <input name="name" class="form-control" placeholder="Vd: Nguyễn Văn A..." aria-describedby="basic-addon1">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Số điện thoại</span>
                            <input name="phone" class="form-control" placeholder="Vd: 0166415..." aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon">Số tiền vay</span>
                            <input id="money" name="money" type="number" class="form-control" placeholder="Vd:10,000,00 Giới hạn từ 10 triệu đến 100 triệu" aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-addon">VNĐ</span>
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Số CMND</span>
                            <input type="number" name="cmnd" class="form-control" placeholder="Vd: 24178......" aria-describedby="basic-addon2">
                        </div> <br>
                    </div>
                    <div class="col-md-6 pull-left">
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Email</span>
                            <input name="email" class="form-control" placeholder="Vd: songdehanhdong@gmail.com" aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Đơn vị công tác</span>
                            <input name="company" class="form-control" placeholder="Vd: Cty TNHH..." aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Địa chỉ</span>
                            <input name="address" class="form-control" placeholder="Vd: 3x Tôn Đức Thắng xxx" aria-describedby="basic-addon2">
                        </div> <br>
                        <div class="input-group">
                            <span class="btn-primary-custom input-group-addon" id="basic-addon1">Thông tin thêm</span>
                            <textarea name="more" class="form-control" placeholder="Vd: Hiện đang dư nợ tại ngần hàng xxx, đang mua trả góp,..." aria-describedby="basic-addon2"></textarea>
                        </div> <br>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="action" value="handler">
<!--                        <input type="submit" id="register" class="col-md-4 col-m4-push-4 btn-danger btn-lg" value="ĐĂNG KÝ VAY">-->
                        <button type="submit" id="register" class="col-md-4 col-m4-push-4 btn-danger btn-lg">ĐĂNG KÝ VAY
                            <small id="small-resgister">Duyệt hồ sơ sau 30 giây.</small>
                        </button>
                       
                    </div>
                </form>
               
            </div>
        </div>
    </div>
    <?php do_action('onepress_section_after_inner', 'features'); ?>

<?php if ( ! onepress_is_selective_refresh() ){ ?>
</section>
<?php } ?>
<?php } ?>