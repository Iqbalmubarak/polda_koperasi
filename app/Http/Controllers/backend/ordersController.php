<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\markets;
use App\Models\brands;
use App\Models\type;
use App\Models\units;
use App\Models\items;
use App\Models\orders;
use App\Models\suppliers;
use App\Models\orders_detail;
use App\Http\Resources\orders as inlist;
use Sentinel;

class ordersController extends Controller
{
public function index()
{
    try {
        $id = 0;
        $user_id = Sentinel::getUser()->id;
        $orders = orders::where('status',0)->where('user_id',$user_id)->first();
        $harga = 0;
        if($orders){
            $id = $orders->id;
            $orders_detail = orders_detail::where('orders_id', $id)->get();
            foreach($orders_detail as $detail){
                $harga = $harga + ($detail->total*($detail->items->modal + $detail->items->price));
            }
        }
        return view('backend.orders.index',compact('id','harga'));
    } 
        catch (\Exception $e) {
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create inventoris | error : ".$e->getMessage());
        return redirect()->back()->withInput();
    }
}

public function confirm(Request $request, $id)
{
try {
    $orders = orders::find($id);
    $orders->status = 1;
    $orders->update();

    toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
    Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah inventoris");
    return redirect()->back();
} catch (\Exception $e) {
    Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit inventoris | error : ".$e->getMessage());
    toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
    return redirect()->back()->withInput();
}
}

public function getData(Request $request)
{
    try {
    $data = [];
    //?data=all&status=
    if($request->data=="all"){
        $user_id = Sentinel::getUser()->id;
        $orders = orders::where('status',0)->where('user_id',$user_id)->first();
        if($orders){
            $data = orders_detail::orderby('id','desc')->where('orders_id', $orders->id)->get();
        }
    }
    //?data=&id=
    elseif($request->data=="id"){
        $user_id = Sentinel::getUser()->id;
        $data = orders::where('status',0)->where('user_id',$user_id)->where('id', $request->id)->first();
    }

    if($data)return response()->json(inlist::collection($data));
    return $data;
    } catch (\Exception $e) {
        return [];
    }
}

}
