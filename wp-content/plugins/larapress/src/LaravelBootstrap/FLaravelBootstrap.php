<?php
namespace WPLaravelBoostrap\LaravelBootstrap;


use WPLaravelBoostrap\WPCore\WPfeature;
use WPLaravelBoostrap\WPCore\View;
use WPLaravelBoostrap\WPCore\WPscriptAdmin;
use WPLaravelBoostrap\WPCore\WPstyleAdmin;
use WPLaravelBoostrap\WPCore\admin\WPsubmenuPage;
use WPLaravelBoostrap\WPCore\admin\WPfeaturePointerLoader;
use WPLaravelBoostrap\WPCore\admin\WPfeaturePointer;
use WPLaravelBoostrap\LaravelBootstrap\LoadLaravel;

class FLaravelBootstrap extends WPfeature
{
    public static $instance;

    protected $version = '0.1';

    protected $featurePointer;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct('feature-plugin-starter', 'feature-plugin-starter');
    }

    public function init()
    {
        if (is_admin()) {
            $this->initAdmin();
        } else {
            $this->initTheme();
        }        
    }

    public function install()
    {
        
    }

    public function uninstall()
    {
        $this->featurePointer->clearDismissed(get_current_user_id());
    }

    public function initAdmin()
    {
        $settingsPage = new WPsubmenuPage(
            new View($this->getViewsPath().'/admin/admin-settings.php'),
            'options-general.php',
            __('LaraPress Settings', 'lara-press'),
            'LaraPress',
            'lara-press',
            'manage_options'
        );
        $this->hook($settingsPage);

        $fpl = new WPfeaturePointerLoader($this->getJsUrl(), 'pointersParams');
        $this->featurePointer = new WPfeaturePointer(
            'laravel_bootstrap_v001',
            '<h3>'.__('Get started now', 'lara-press').'</h3>'.
            '<p>'.sprintf(__('Please add your Laravel root folder %sLaravel Bootstrap settings%s', 'lara-press'), '<a href="'.$settingsPage->getUrl().'">', '</a>').'</p>',
            '#menu-settings',
            array(
                'edge' => 'left',
                'align' => 'center'
            )
        );
        $fpl->addPointer($this->featurePointer);
        $this->hook($fpl);

    }

    public function initTheme()
    {
        $laravelBoot = new LoadLaravel();
        $laravelBoot->bootLaravel();
    }
}
