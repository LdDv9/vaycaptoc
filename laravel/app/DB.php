<?php


//include_once asset('/laravel/vendor/autoload.php');


use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
'driver'    => 'mysql',
'host'      => 'db4free.net:3307',
'database'  => 'db_free',
'username'  => 'ld_cao',
'password'  => '123456',
'charset'   => 'utf8',
'collation' => 'utf8_unicode_ci',
'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();
return $capsule;