<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public function isAjax()
    {
        if ( ! defined('DOING_AJAX') || ! DOING_AJAX) {
            return false;
        } else {
            return true;
        }
    }
    public function ajaxHandler()
    {
        if ($this->isAjax()) {

            $result = array(
                'status'  => 'error',
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại'
            );

            if ( ! empty( $_POST["method"] )) {
                $method = sanitize_text_field($_POST["method"]);
                if (method_exists($this, "ajax" . $method)) {
                    $result = call_user_func([$this, "ajax" . $method], $_POST);
                }
            } else  if ( ! empty( $_GET["method"] )) {
                $method = sanitize_text_field($_GET["method"]);
                if (method_exists($this, "ajax" . $method)) {
                    $result = call_user_func([$this, "ajax" . $method], $_GET);
                }
            }

            echo json_encode($result);
            exit;

        }
    }
}
