<?php

namespace App\Models;
use Sentinel;
use Illuminate\Database\Eloquent\Model;
use App\Models\units;

class items extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'brand_id',
        'unit_id',
        'type_id'
    ];

    public function purchase()
    {
        return $this->hasMany(purchase::class,'item_id', 'id');
    }

    
    public function type()
    {
        return $this->hasOne(type::class, 'id', 'type_id');
    }

    
    public function units()
    {
        return $this->hasOne(units::class, 'id', 'unit_id');
    }

    
    public function orders()
    {
        return $this->hasMany(orders::class);
    }

    
    public function brands()
    {
        return $this->hasOne(brands::class, 'id', 'brand_id');
    }




}
