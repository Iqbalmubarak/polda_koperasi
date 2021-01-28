<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders_detail extends Model
{
    protected $table = 'orders_detail';

    protected $fillable = [
        'items_id'
    ];

    public function items()
    {
        return $this->hasOne(items::class, 'id', 'item_id');
    }

    
    public function orders()
    {
        return $this->hasOne(orders::class, 'id', 'orders_id');
    }
    

}
