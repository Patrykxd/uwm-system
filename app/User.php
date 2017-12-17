<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'id','name', 'email','roles','password','remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $table = 'cms_users';

}
