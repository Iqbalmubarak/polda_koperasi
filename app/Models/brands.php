<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class brands extends Model
{
        protected $table = 'brands';

    protected $fillable = [
        'name'

    ];

    public function items()
    {
        return $this->hasMany(items::class);
    }
}
