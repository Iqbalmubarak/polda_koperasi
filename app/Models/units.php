<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class units extends Model
{
    protected $table = 'units';

    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(items::class);
    }
}
