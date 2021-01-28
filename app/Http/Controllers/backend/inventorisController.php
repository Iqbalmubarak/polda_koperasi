<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\inventoris;
use App\Models\satuan;
use App\Models\jenis;
use App\Models\barang;
use App\Models\inventorisSumber as sumber;
use App\Models\inventorisDetail as id;
use Sentinel;
use App\Http\Resources\inventorisList as inlist;
use Illuminate\Support\Facades\DB;

class inventorisController extends Controller
{
  public function index(Request $request)
  {
      try {

        $barang = barang::pluck('nama_barang','id');
        $satuan = satuan::pluck('nama_satuan','id');
        $jenis = jenis::pluck('nama_jenis','id');
        return view('backend.inventoris.index',compact('barang','satuan','jenis'));
      } catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
      }
  }

  public function create(Request $request)
  {
      $barang = barang::pluck('name','id');
      $satker = satuanKerja::where('status',1)->orwhere('id',1)->get()->pluck('name','id');
      if($request->status=="not-available"){
        $satker = satuanKerja::where('status',0)->where('id','<>',1)->get()->pluck('name','id');
      }
      $satuan = satuanBarang::pluck('name','id');
      return view('backend.inventoris.create',compact('barang','satker','satuan'));
  }

  public function show($id)
  {

      $data = inventoris::find($id);
      if(Sentinel::getUser()->hasAccess(['inventoris.self-data'])){
        $data = inventoris::where('id',$id)->where('satker_id',Sentinel::getUser()->satker_id)->first();
        if(!$data){
          toast()->error('Data Not Found', 'Eror');
          return redirect()->back();
        }
      }

      $barang = barang::pluck('name','id');
      $satuan = satuanBarang::pluck('name','id');
      $sumber = sumber::select('inventoris_sumber.id','inventoris_sumber.name')->where('inventoris_sumber.id','<>',1)->get();
      if(Sentinel::getUser()->hasAccess(['inventoris.all-data']) && $data->satker_id != 1){
        $sumber = sumber::select('inventoris_sumber.id',DB::RAW("concat(inventoris_sumber.name,' (',sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END),')') as name"))
                  ->join('inventoris_detail','inventoris_sumber.id','=','inventoris_detail.sumber_id')
                  ->join('inventoris','inventoris_detail.inventoris_id','=','inventoris.id')
                  ->where('inventoris_sumber.id','<>',1)
                  ->where('inventoris.barang_id',$data->barang_id)
                  ->where('inventoris.satuan_id',$data->satuan_id)
                  ->where(function ($query){
                    $query->where('inventoris.satker_id',1)->orwhere('inventoris_detail.status',1);
                  })
                  ->groupby('inventoris_sumber.id')
                  ->orderby(DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END)"),'desc')
                  ->get();
      }

      if($sumber->count()>0){
        $sumber = $sumber->pluck('name','id')->union(['xxx'=>'Lainnya']);
      }

      if($data->satker_id==1){
        return view('backend.inventoris.showDinkes',compact('barang','sumber','satuan','data'));
      }
      return view('backend.inventoris.show',compact('barang','sumber','satuan','data'));
  }

  public function store(Request $request)
  {
    $request->validate([
        'barang' => 'required',
        'satuan' => 'required',
    ]);

    try {
        $satker_id = Sentinel::getUser()->satker_id;
        $status = 0;
        if(Sentinel::getUser()->hasAccess(['inventoris.all-data'])){
          $satker_id = 1;

          if($satker_id!=1){
            $status = 1;
            $data = inventoris::where('barang_id',$request->barang)->where('satuan_id',$request->satuan)->where('satker_id', 1)->first();
            if($data){
              if($data->masuk()->where('inventoris_detail.sumber_id',$sumber)->get()->sum('total') < $request->total ){
                toast()->warning('Barang dengan satuan dan sumber tidak mencukupi', 'warning');
                Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning ketika Menambahkan Barang Satker Lain");
                return redirect()->back()->withInput();
              }
            }else{
              toast()->warning('Barang dengan satuan dan sumber tidak mencukupi', 'warning');
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning ketika Menambahkan Barang Satker Lain");
              return redirect()->back()->withInput();
            }
          }

        }
        $inventoris = inventoris::where('barang_id',$request->barang)->where('satuan_id',$request->satuan)->where('satker_id',$satker_id);
        if($inventoris->get()->count() > 0){
          $inventoris = $inventoris->first();
        }else{
            $inventoris = new inventoris;
            $inventoris->barang_id = $request->barang;
            $inventoris->satuan_id = $request->satuan;
            $inventoris->satker_id = $satker_id;
            $inventoris->save();
        }

        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah inventoris");
        $status = 'available';
        if($inventoris->satker_id!=1){
          $status = $inventoris->satker->status==1 ? 'available' : 'not-available';
        }
        return redirect("inventoris?status=$status");
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
