<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\orders;
use App\Models\brands;
use App\Models\units;
use App\Models\type;
use App\Models\orders_detail as details;
use App\Http\Resources\transaksiList;
use Sentinel;

class transaksiController extends Controller
{
    public function index()
    {
        try {
        return view('backend.transaksi.index');
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $data = orders::find($id);
            if(Sentinel::getUser()->hasAccess(['transaksi.self-data'])){
                $data = orders::where('id',$id)->where('user_id',Sentinel::getUser()->user_id)->first();
                if(!$data){
                    toast()->error('Data Not Found', 'Eror');
                    return redirect()->back();
                }
            }
            // dd($data);
            $brands = brands::pluck('name','id');
            $units = units::pluck('name','id');
            $type = type::pluck('name','id');
            return view('backend.transaksi.show',compact('data','brands','units','type'));
        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Show Detail Order | error : ".$e->getMessage());
            toast()->error('Terjadi Error', 'Eror');
            return redirect()->back();
        }
    }

    public function getData(Request $request)
    {
        //2 role(all, self)
        $data = [];
        //?data=all&status=
        if($request->data=="all"){
            $data = orders::select('orders.*');
            if(Sentinel::getUser()->hasAccess(['transaksi.self-data'])){
                $data = $data->where('user_id',Sentinel::getUser()->id);
            }elseif(Sentinel::getUser()->hasAccess(['transaksi.all-data'])){
                $data->where('status',$request->status);
            }
            $data = $data->orderby('created_at','desc')->get();
        }
        //?data=&id=
        elseif($request->data=="id"){
            $data = orders::find($request->id);
            if(Sentinel::getUser()->hasAccess(['transaksi.self-data'])){
                $data = orders::where('user_id',Sentinel::getUser()->user_id)->where('id',$request->id)->first();
            }
        }
        if($data){
            return response()->json(transaksiList::collection($data));
        }
        return response()->json($data);
    }

    public function send($id){
        try{
            $data = orders::find($id);
            $data->status = 2;
            $data->update();

            foreach($data->details as $detail){
                $detail->items->stock = $detail->items->stock - $detail->total;
                $detail->items->update();
            }

            toast()->success('Berhasil melakukan pengiriman barang');
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Melakukan Pengiriman Barang");
            return redirect()->back();
        }catch(\Exception $e){
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Send Order | error : ".$e->getMessage());
            toast()->error('Terjadi Error', 'Eror');
            return redirect()->back();
        }
    }
}
