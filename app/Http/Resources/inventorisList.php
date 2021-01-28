<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class inventorisList extends Resource
{
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'brands' => $this->brands->name,
          'units' => $this->units->name,
          'type' => $this->type->name,
          'price' => $this->price,
        ];
    }
}
