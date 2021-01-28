<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'addres'
    ];

    public function purchase()
    {
        return $this->hasMany(purchase::class);
    }

}
