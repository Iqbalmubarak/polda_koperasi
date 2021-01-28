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
use App\Models\orders_detail;

use Sentinel;
use App\Http\Resources\inventorisList as inlist;
use Illuminate\Support\Facades\DB;

class marketsController extends Controller
{
  public function index(Request $request)
  {
      try {

        $brands = brands::pluck('name','id');
        $units = units::pluck('name','id');
        $type = type::pluck('name','id');
        $items = items::where('stock','>',0)->get();
        return view('backend.marketplace.index',compact('brands','units','type','items'));
      } catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
      }
  }

  public function create($id)
  {
    $data = items::find($id);
    return view('backend.marketplace.create',compact('data'));
  }

  public function store(Request $request, $id)
  {
    $request->validate([
        'total' => 'required',
    ]);

    try {
      $user_id = Sentinel::getUser()->id;
      $orders = orders::where('status',0)->where('user_id',$user_id)->first();

      if(!$orders){
          $orders = new orders;
          $orders->user_id = $user_id;
          $orders->save();
      }

      $orders_detail = new orders_detail;
      $orders_detail->orders_id = $orders->id;
      $orders_detail->item_id = $id;
      $orders_detail->total = $request->total;          
      $orders_detail->save();


      toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
      Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Barang");
      return redirect()->route('markets.index');
    } catch (\Exception $e) {
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create inventoris | error : ".$e->getMessage());
        return redirect()->back()->withInput();
    }
  }

 
  public function update(Request $request, $id)
  {
    try {
      $request->validate([
          'barang' => 'required',
          'satuan' => 'required'
      ]);

      $satker_id = Sentinel::getUser()->satker_id;
      if(Sentinel::getUser()->hasAccess(['inventoris.all-data'])){
        $inven = inventoris::find($id);
        $satker_id = $inven->satker_id;
      }

      $inventoris = inventoris::where('id',$id)->where('satker_id',$satker_id)->first();
      if(!$inventoris){
        toast()->error('Data Not Found', 'Eror');
        return redirect()->back();
      }

      $inventoris = inventoris::where('barang_id',$request->barang)->where('satuan_id',$request->satuan)->where('satker_id',$satker_id)->where('id','<>',$id);
      if($inventoris->get()->count() > 0){
        toast()->warning('Inventoris Lain Telah Terdaftar, Silakan Update Inventoris yang di inginkan', 'gagal');
        return redirect()->back();
      }
      $inventoris = inventoris::where('id',$id)->where('satker_id',$satker_id)->first();
      $inventoris->barang_id = $request->barang;
      $inventoris->satuan_id = $request->satuan;
      $inventoris->update();

      toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
      Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah inventoris");
      return redirect()->back();
    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit inventoris | error : ".$e->getMessage());
        toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
        return redirect()->back()->withInput();
    }
  }


  public function destroy($id)
  {
    $inventoris = "";
    try {
        $inventoris = inventoris::where('id',$id)->where('satker_id',Sentinel::getUser()->satker_id)->first();
        if(Sentinel::getUser()->hasAccess(['inventoris.all-data'])){
          $inventoris = inventoris::find($id);
        }

        if(!$inventoris){
          toast()->error('Data Not Found', 'Eror');
          return redirect()->back();
        }

        $inventoris->delete();
        toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Inventoris");

    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Inventoris | error : ".$e->getMessage());
        toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
    }

    $status = 'available';
    if($inventoris->satker_id!=1){
      $status = $inventoris->satker->status==1 ? 'available' : 'not-available';
    }
    return redirect("inventoris?status=$status");
  }

  public function getData(Request $request)
  {
    $data = [];
    //?data
    if($request->data=="all"){
      $data = markets::orderby('id','desc')->get();
    }
    //?data=&id=
    elseif($request->data=="id"){
      $data = markets::find($request->id);
    }

    return response()->json($data);

  }

}
