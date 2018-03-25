<?php 

namespace WPLaravelBoostrap\LaravelBootstrap;

use WPLaravelBoostrap\WPCore\WPoption;

//Get All ISoft Product Categories

class LoadLaravel
{
    protected $laravelRoot;

    protected $app;

    protected $autoloadFile = '/vendor/autoload.php';

    protected $appFile = '/bootstrap/app.php';

    /**
     * Contructor
     *
     * @param  
     * @return 
     */
    public function __construct()
    {
        $this->laravelRoot = new WPoption('laravel_root');
    }


    /**
     * Boot laravel
     *
     * @param  
     * @return 
     */
    
    public function bootLaravel()
    {
        if(empty($this->laravelRoot->getValue())) return;
        if(!$this->laravel_exists()) return;
        
        require $this->laravelRoot->getValue().$this->autoloadFile;

        $this->app = require_once $this->laravelRoot->getValue().$this->appFile;

        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);

        $response = $kernel->handle(
            $request = \Illuminate\Http\Request::capture()
        );

        $kernel->terminate($request, $response);

        $this->bootSession();            

    }

    /**
     * Is Laravel exists
     *
     * @param  
     * @return bool
     */
    public function laravel_exists()
    {
        $fileBootstrap = $this->laravelRoot->getValue().$this->appFile;
        $fileAutoLoad  = $this->laravelRoot->getValue().$this->autoloadFile;
        if (file_exists($fileBootstrap)) {
            return $fileAutoLoad;
        } else {
            return false;
        }
    }

    /**
     * Boot the session
     *
     * @param  
     * @return 
     */
    public function bootSession()
    {
        if(!isset($_COOKIE[$this->app['config']['session.cookie']])){
            return;
        }
        
        $id = $this->app['encrypter']->decrypt($_COOKIE[$this->app['config']['session.cookie']]);

        $this->app['session']->driver()->setId($id);

        $this->app['session']->driver()->start();

    }
}