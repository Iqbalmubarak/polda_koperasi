<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class orders extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            //Orders
            'id' => $this->id,
            'total' => $this->total,
            'items' => $this->items->name,
            'harga' => $this->total*($this->items->modal + $this->items->price), 
        ];
    }
}
