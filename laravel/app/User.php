<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
     public function getUsers() {
         $DB = require 'DB.php';
         $data = $DB->table('wp_users')->where('ID',1)->first();
         return $data;
     }
     public function getPost(){
         $DB = require 'DB.php';
         $data = $DB->table('wp_posts')->where('post_status','publish')->get();
         return $data;
     }
    public function signIn($data){
         $result = [];
        $arrSignIn = [
            'user_login' => 'ld_cao',
            'user_password' => '01664153347'
        ];
        $resultSignIn = wp_signon($arrSignIn);
        if (!empty($resultSignIn->errors)) {
            $result['errors'] = 1;
            foreach ($resultSignIn->errors as $listErrors) {
               $result['mess'] = $listErrors[0];
            }
        } else {
            $result = [
                'success' => 1,
                'mess'    => 'Sign in success'
            ];
        }
        return $result;
    }
}
