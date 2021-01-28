<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    protected $table = 'type';

    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(items::class);
    }

}
