<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'avatar',
        'alamat',
        'no_hp',
        'permissions',
        'last_login',
        'satker_id',
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(orders::class, 'user_id', 'id');
    }

}
