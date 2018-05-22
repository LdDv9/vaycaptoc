<?php
/**
 * Template Name: Statistic Guests
 */
use WeDevs\ORM\Eloquent\Database as DB;
$DB = new DB();

//$data = $DB->table('guests')->paginate(50);
//echo '<pre>';
//var_dump($data->render());
//echo '</pre>';
//exit();





$current= !empty(get_query_var('page')) ? sanitize_text_field(get_query_var('page')) : 1;
$limit = 50;
$from = (int)$current*$limit-$limit;
global $wpdb;
$data = $wpdb->get_results("SELECT * FROM `v_guests` ORDER BY `created_at` DESC LIMIT $from, $limit ");
$dataTuyenDung = $wpdb->get_results("SELECT * FROM `v_employees`");
$dataOnSite = count($data);
$total = $wpdb->get_var( "SELECT COUNT(id) AS total FROM `v_guests`");

if ($dataOnSite < 50) {
    $startData = 0;
} else {
    $startData = $total - 50;
}
get_header();
if (is_user_logged_in()) {
    if (current_user_can('administrator')) {
        ?>
        <div class="container-fluid" style="padding: 50px 20px 50px 20px">
            <div class="row">
                <div class="text-center">
                   <p class="lead">
                       <?php echo "Hiển thị <b>$dataOnSite</b> trên tổng số <b>$total</b> dữ liệu, bắt đầu từ dữ liệu thứ <b>$startData</b>"?>
                   </p>
               </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Số tiền vay</th>
                            <th>CMND</th>
                            <th>Email</th>
                            <th>Công ty</th>
                            <th>Loại vay</th>
                            <th>Ghi Chú</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $list) :?>
                            <tr>
                                <td><?=$list->id?></td>
                                <td><?=$list->name?></td>
                                <td>
                                    <a href="tel:<?=$list->phone?>"><?=$list->phone?></a>
                                </td>
                                <td><?=number_format($list->money).' VNĐ'?></td>
                                <td><?=$list->cmnd?></td>
                                <td><?=$list->email?></td>
                                <td><?=$list->company?></td>
                                <td><?=$list->type?></td>
                                <td><?=$list->more?></td>
                                <td><?=date('H:i:s   d-m-Y',strtotime($list->created_at))?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <?php if($total > $limit) :?>
                    <ul class="pagination">
                        <?php
                        $i = 1;
                        for ($i = 1; $i < $total/$limit; $i++) {
                            $active = '';
                            if ($i == (int)$current) {
                                $active = "class='active'";
                            }
                            echo "<li $active><a href='".WP_HOME."/statictis-guest?page=$i"."' >$i</a></li>";
                        }
                        if ($i - $total/$limit > 0) {
                            $active = '';
                            if ($i == (int)$current) {
                                $active = "class='active'";
                            }
                            echo "<li $active><a href='".WP_HOME."/statictis-guest?page=$i"."' >$i</a></li>";
                        }
                        ?>
                    </ul>
                  <?php endif ?>
                </div>
                <br>
                <br>
                <br>
                <h2 class="text-center">Danh sách đăng ký ứng tuyển</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Mức lương</th>
                            <th>Ngày sinh</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dataTuyenDung as $list) :?>
                            <tr>
                                <td><?=$list->id?></td>
                                <td><?=$list->name?></td>
                                <td>
                                    <a href="tel:<?=$list->phone?>"><?=$list->phone?></a>
                                </td>
                                <td><?=$list->email?></td>
                                <td><?=$list->address?></td>
                                <td><?=number_format($list->money).' VNĐ'?></td>
                                <td><?=$list->dob?></td>

                                <td><?=date('H:i:s   d-m-Y',strtotime($list->created_at))?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p class='lead text-center' style='margin-top: 300px; margin-bottom: 300px'> Đi chỗ khác chơi đi bạn :)</p>";
    }
} else {
    echo "<p class='lead text-center' style='margin-top: 300px; margin-bottom: 300px'> Chưa đăng nhập <a href=".wp_login_url($_SERVER['REQUEST_URI']).">Đăng nhập</a></p>";
}
get_footer();
