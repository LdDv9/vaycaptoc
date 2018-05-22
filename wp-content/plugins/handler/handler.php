<?php
/*
Plugin Name: Handler
Plugin URI: http://fb.com/ld.dv9
Version: 0.2
Author: Lê Dũng(Cáo).
Author URI: http://fb.com/ld.dv9
*/
//require_once 'API/API.php';
require_once 'vendor/autoload.php';
\VCT\API::init();

add_action('wp_ajax_handler','registerGuest');
add_action('wp_ajax_nopriv_handler','registerGuest');
function registerGuest(){
    global $wpdb;
    $name = !empty($_REQUEST['name']) ? $_REQUEST['name']:'';
    $phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone']:'';
    $money = !empty($_REQUEST['money']) ? $_REQUEST['money']:'';
    $cmnd = !empty($_REQUEST['cmnd']) ? $_REQUEST['cmnd']:'';
    $email = !empty($_REQUEST['email']) ? $_REQUEST['email']:'';
    $company = !empty($_REQUEST['company']) ? $_REQUEST['company']:'';
    $type = !empty($_REQUEST['type']) ? $_REQUEST['type']:'';
    $more = !empty($_REQUEST['more']) ? $_REQUEST['more']:'';
    $money = (int)$money;
    
    if (empty($name)) {
        wp_send_json_error('Bạn chưa nhập tên!');
    }
    if(empty($phone) || is_integer($phone) || strlen($phone) < 10 ){
        wp_send_json_error('Số điện thoại sai định dạng hoặc chưa nhập, vui lòng thử lại!');
    }
    if(empty($money)){
        wp_send_json_error('Bạn chưa nhập số tiền muốn vay!');
    }
    if(!empty($money) && strlen($money) < 8 || !empty($money) && $money - 100000000 > 0 && is_integer($money)){
        wp_send_json_error('Xin lỗi số tiền bạn vay quá ít hoặc quá nhiều, yêu cầu từ 10,000,000 vnđ - 100,000,000 vnđ!');
    }
    if(empty($cmnd) || strlen($cmnd) != 9 && ($cmnd) != 12){
        wp_send_json_error('Bạn chưa nhập số CMND hoặc CMND sai định dạng 9 số hoặc 12 số!');
    }
    if(!empty($email) && !is_email($email)){
        wp_send_json_error('Bạn đã nhập email, nhưng email sai định dạng!');
    }
    if(empty($type)){
        wp_send_json_error('Bạn chưa chọn thể loại vay!');
    }
    $dataInsert = [
        'name'  => $name,
        'phone' => $phone,
        'money' => $money,
        'cmnd'  => $cmnd,
        'email' => $email,
        'company'   => $company,
        'type'   => $type,
        'more'      => $more,
        'created_at'    => current_time('mysql')
    ];
    
    $result = $wpdb->insert('v_guests',$dataInsert);
    if (!empty($result)) {
        if (!empty($email)) {
            $money = number_format($money);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $content = file_get_contents("https://vaycaptoc.com/asset/mail/send_guest.php?name=$name&money=$money");
            wp_mail($email,'Chúc mừng bạn đã đẵng ký vay thành công',$content,$headers);
        }
        wp_mail('songdehanhdong@gmail.com','Thông báo có khách hàng đăng ký vay từ hệ thống web','Ê thằng ngu có khách đăng ký lúc'.date('Y-m-d h-i-s'));
        wp_send_json_success("Chúc mừng $name bạn đã đăng ký vay thành công, chúng tôi sẽ sớm liên hệ với bạn!");
    } else {
        wp_send_json_error('Thật xin lỗi, đã có lỗi trong quá trình xử lý!');
    }
    
}
//
add_action('wp_ajax_tuyen_dung','tuyenDung');
add_action('wp_ajax_nopriv_tuyen_dung','tuyenDung');
function tuyenDung(){
    global $wpdb;
    $name = !empty($_REQUEST['name']) ? $_REQUEST['name']:'';
    $phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone']:'';
    $money = !empty($_REQUEST['money']) ? $_REQUEST['money']:'';
    $email = !empty($_REQUEST['email']) ? $_REQUEST['email']:'';
    $dob = !empty($_REQUEST['dob']) ? $_REQUEST['dob']:'';
    $address = !empty($_REQUEST['address']) ? $_REQUEST['address']:'';
    $money = (int)$money;
    $dob = date('Y-m-d',strtotime(str_replace('/','-',$dob)));
    $dataInsert = [
        'name'  => $name,
        'phone' => $phone,
        'money' => $money,
        'email' => $email,
        'dob'   => $dob,
        'address' => $address,
        'created_at'    => current_time('mysql')
    ];
    $result = $wpdb->insert('v_employees',$dataInsert);
    if (!empty($result)) {
        if (!empty($email)) {
            $money = number_format($money);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($email,"Chúc mừng $name bạn đã đẵng ký ứng tuyển thành công","
                Chào $name, bạn đã đăng ký ứng tuyển vào vị trí hỗ trợ khách hàng của <a href='https://vaycaptoc.com'>Vaycaptoc.com</a> với mức lương mong muống là $money Vnđ <br>
                Khi bạn nhận được thư này nghĩa là chúng tôi đã nhận được thông tin của bạn và sẽ liên hệ với bạn qua số điện thoại trong thời gian ngắn nhất. <br>
                Trân trọng <br>
                Vay cấp tốc <br>
                <a href='https://vaycaptoc.com'>Vay Cấp Tốc</a>
            ",$headers);
        }
        wp_mail('songdehanhdong@gmail.com','Thông báo có người ứng tuyển','Ê thằng ngu có đứa đăng ký ứng tuyển kìa:'.date('Y-m-d h-i-s')."
        Tên : $name <br/>
        Mức lương : $money <br/>        
        ");
        wp_send_json_success("Chúc mừng $name bạn đã đăng ký ứng tuyển, chúng tôi sẽ sớm liên hệ với bạn!");
    } else {
        wp_send_json_error('Thật xin lỗi, đã có lỗi trong quá trình xử lý!');
    }
}
