<?php
use WPLaravelBoostrap\WPCore\WPoption;
use WPLaravelBoostrap\LaravelBootstrap\LoadLaravel;

$laravelRoot   = new WPoption('laravel_root');
$laravel = new LoadLaravel; 

$statusMsg = "";
$class = 'lara-press-success';
$nonce = !empty($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : false;


if (!empty($_POST['pluginOptionsSubmit'])) {
    if(!wp_verify_nonce( $nonce, 'lara-press' )) {
        exit('Nonce Invalid');
    }
    $optionValue = rtrim($_POST['laravel_root'], '/');
    $laravelRoot->setValue($optionValue);
    $laravelRoot->save();
    if(!file_exists($_POST['laravel_root'].'/vendor/autoload.php')){
        $class = 'text-danger';
        $statusMsg = __('Xin lỗi chúng tôi không thể tìm thấy thư mục laravel yêu cầu');
    }else{
        $class = 'text-success lead';
        $statusMsg = __('Thành công');
    }    
}

$value = $laravelRoot->getValue() ?: $_SERVER['DOCUMENT_ROOT'];
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
    .lara-press-status.{
    }
    .lara-press-success:before{
        color:#449d44;
    }
    .lara-press-error:before{
        color:#d9534f;
    }
</style>
<h1><?php _e('LaraPress-VI Cài Đặt');?></h1>
<p class="lead"><?php _e('Đây là những bước cài đặt đầu tiền để plugin có thể chạy, hãy tạo 1 thư mục laravel chứa dự án laravel
            của bạn trong thư mục wordpress, nên để thư mục ,laravel bằng cấp với file index.php của wordpress.');?></p>
<form action="" method="post">
<?php wp_nonce_field('lara-press') ?>
<table class="form-table">
<tbody><tr>
    <th><label for="category_base"><?php _e('Đường dẫn tới thư mục laravel');?></label></th>
    <td><input name="laravel_root" id="laravel_root" type="text" value="<?php echo $value; ?>" class="regular-text code">
    <p class="description"><?php _e('Hãy chắc chắn rằng đây là thư mục gốc của laravel.');?></p>
    </td>
</tr>

</tbody></table>
<p class="submit"><input id="pluginOptionsSubmit" name="pluginOptionsSubmit" type="submit" class="button button-primary" value="Lưu"></p>
<p><?php echo $statusMsg;?><p>
<?php if($laravel->laravel_exists()){?>
    <?php echo $laravel->laravel_exists()?>
<p class="lara-press-status lara-press-success dashicons-before dashicons-yes lead text-success "> <?php _e('Laravel hiện đang được khởi động đúng cách');?></p>
<p><?php _e('Bây giời bạn có thể kết hợp laravel và wordpress lại với nhau. ví dụ', 'lara-press');?></p>
<textarea cols="50" rows="7" name="newcontent" id="newcontent" aria-describedby="newcontent-description">
  <?php echo "<?php";?>
  <?php echo "\nif (is_callable('Auth'))\n{";?>
  <?php echo "\n    Auth::check();";?>
  <?php echo "\n}";?>
  <?php echo "\n?>";?>
  
</textarea>
<p class="lead"><?php _e('Hãy chắc chắn rằng plugin luôn được khởi động nếu không ứng dụng sẽ gặp lỗi nghiêm trọng');?></p>
<?php }else{?>
<p class="lara-press-status lara-press-error dashicons-before dashicons-no-alt text-danger lead"> <?php _e('Xin lỗi, chúng tôi không thể tìm thấy thư mục laravel ');?></p>
<?php }?>
</form>
