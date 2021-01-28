<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class inventorisRequestList extends Resource
{
    public function toArray($request)
    {
        
        return [
        'id' => $this->id,
        'total' => $this->total,
        'items' => $this->items->name,
        'harga' => $this->items->modal + $this->items->price,     
        ];
    }
}
