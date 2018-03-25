<?php
/*
Plugin Name: LaraPress-VI
Plugin URI: http://fb.com/ld.dv9
Description: Plugin kết hợp giữa laravel và wordpress, plugin được xây dựng lại dựa trên nền tảng cũ của nhà phát hành https://github.com/larapress-cms/larapress
Version: 0.2
Author: Lê Dũng(Cáo).
Author URI: http://fb.com/ld.dv9
*/
namespace WPLaravelBoostrap;

use WPLaravelBoostrap\LaravelBootstrap\LoadLaravel;
use WPLaravelBoostrap\WPCore\admin\WPadminNotice;
use WPLaravelBoostrap\WPCore\View;
use WPLaravelBoostrap\WPCore\WPplugin;
use WPLaravelBoostrap\LaravelBootstrap\FLaravelBootstrap;

require 'autoload.php';
class LaravelBootstrap extends WPplugin
{

    public static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        load_plugin_textdomain('lara-press', false, dirname(plugin_basename(__FILE__)).'/lang');

        parent::__construct(__FILE__, 'Laravel Bootstrap', 'lara-press');
        
        $this->setReqWpVersion("3.5");
        $this->setReqWPMsg(sprintf(__('%s Requirements failed. WP version must at least %s', 'lara-press'), $this->getName(), $this->reqWPVersion));
        $this->setReqPhpVersion("5.3.3");
        $this->setReqPHPMsg(sprintf(__('%s Requirements failed. PHP version must at least %s', 'lara-press'), $this->getName(), $this->reqPHPVersion));
        $this->setMainFeature(FLaravelBootstrap::getInstance());
        parent::init();
        $loadLaravel = new LoadLaravel();
        if (!empty($loadLaravel->laravel_exists())) {
            require_once $loadLaravel->laravel_exists();
            require_once 'CallAjax.php';
        }


    }
}
$LaravelBootstrap = LaravelBootstrap::getInstance();
$LaravelBootstrap->register();
