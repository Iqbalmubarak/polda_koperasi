<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    protected $table = 'purchase';

    protected $fillable = [
        'item_id',
        'supplier_id',
        'cost',
        'total',
        'date'
    ];

    public function items()
    {
        return $this->hasOne(items::class, 'id', 'item_id');
    }

    
    public function suppliers()
    {
        return $this->hasOne(suppliers::class, 'id', 'supplier_id');
    }

}
