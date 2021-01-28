<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'item_id'

    ];

    public function items()
    {
        return $this->hasOne(items::class, 'id', 'item_id');
    }
    
    public function users()
    {
        return $this->hasOne(users::class, 'id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(orders_detail::class, 'orders_id', 'id');
    }

}
