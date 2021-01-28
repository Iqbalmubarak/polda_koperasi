<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class transaksiList extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = "Diproses";
        if($this->status==2){
            $status = "Diterima";
        }elseif($this->status==3){
            $status = "Dibatalkan";
        }
        return [
            //Orders
            'id' => $this->id,
            'tanggal' => date_format($this->created_at, "d-m-Y"),
            'user' => $this->users->first_name.' '.$this->users->last_name,
            'status' => $status,
            'total' => $this->details->count(),
        ];
    }
}
