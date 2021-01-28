<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Illuminate\Support\Facades\Log;
use App\Models\purchase as id;
use App\Models\items;
use App\Models\purchase;
use App\Models\suppliers;
use Illuminate\Support\Facades\DB;

class inventorisDetailController extends Controller
{
    public function store($inventoris_id, Request $request)
    {

        $request->validate([
            'suppliers' => 'required',
            'date' => 'required',
            'total' => 'required',
            'cost' => 'required'
        ]);
        try {

            $sumber = $request->suppliers;

                // dd($sumber);
              $modal=0;
              $new_modal=0;

              $purchase = new id();
              $purchase->item_id = $inventoris_id;
              $purchase->supplier_id = $sumber;
              $purchase->date = $request->date;
              $purchase->total = $request->total;
              $purchase->cost = $request->cost;

              if($request->expired){
                $purchase->expired = $request->expired;
              }
              
              $purchase->save();

              $purchase_count = purchase::where('item_id',$inventoris_id)->get();

              if($purchase_count){
                $total = $purchase_count->count();
                $count = DB::table('purchase')->where('item_id',$inventoris_id)->get();
                try{
                foreach($count as $counting){
                  $modal = $modal + $counting->cost;
                }
                
                $new_modal = $modal / $total;
                }catch (\Exception $e) {
                    $new_modal = $request->cost;
                }
              }else{
                $new_modal = $request->cost;
              }

              $items = items::find($inventoris_id);
              $items->stock = $items->stock + $request->total;
              $items->modal = $new_modal;
              $items->update();

              toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
            
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Detail inventoris");
        } catch (\Exception $e) {
            toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Detail inventoris | error : ".$e->getMessage());
        }
        return redirect()->back();
    }

    public function update($inventoris_id, Request $request, $id)
    {
        $request->validate([
            'sumber' => 'required',
            'tanggal' => 'required',
            'total' => 'required',
        ]);
        try {
            $sumber = $request->sumber;
            if($sumber=='xxx'){
              $sumber = 0;
            }
            $inventorisDetail = id::where('inventoris_id',$inventoris_id)->where('sumber_id',$sumber)->where('tanggal',$request->tanggal)->where('id','<>',$id);
            if($inventorisDetail->get()->count() > 0){
              toast()->warning('Detail Inventoris Lain Telah Terdaftar, Silakan Update Detail Inventoris yang di inginkan', 'gagal');
              return redirect()->back();
            }else{
              if($sumber==0){
                $request->validate([
                  'sumber_lain' => 'required'
                ]);

                if($request->sumber_lain=="xxx"){
                  toast()->warning('Harap Kolom Sumber Lain di isi dengan Benar', 'warning');
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Memasukan Sumber XXX");
                  return redirect()->back()->withInput();
                }
                $sumber = sumber::create(['name'=>$request->sumber_lain]);
                $sumber = $sumber->id;
              }
              $inventorisDetail = id::find($id);
              if($inventorisDetail->inventoris_id!=1){
                $inventoris = inventoris::find($inventorisDetail->inventoris_id);
                if((($inventoris->details->sum('total')-$inventorisDetail->total)-$inventoris->keluar()->sum('total'))+$request->total <= 0){
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data inventoris masuk yang menyebabkan sisa minus ");
                  toast()->error('Tidak Bisa Merubah Data, Perubahan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
                  return redirect()->back();
                }
              }else{
                $inventoris = inventoris::find($inventorisDetail->inventoris_id);
                if((($inventoris->details->sum('total')-$inventorisDetail->total)-$inventoris->keluarDinkes()->sum('total'))+$request->total <= 0){
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data inventoris masuk yang menyebabkan sisa minus ");
                  toast()->error('Tidak Bisa Merubah Data, Perubahan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
                  return redirect()->back();
                }
              }
              $inventorisDetail->inventoris_id = $inventoris_id;
              $inventorisDetail->sumber_id = $sumber;
              $inventorisDetail->tanggal = $request->tanggal;
              $inventorisDetail->total = $request->total;
              $inventorisDetail->update();
            }
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah Detail inventoris");
        } catch (\Exception $e) {
            toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Update Detail inventoris | error : ".$e->getMessage());
        }
        return redirect()->back();
    }

    public function destroy($inventoris_id, $id)
    {
      try {
          $modal=0;
          $new_modal=0;
          $inventorisDetail = id::find($id);

          $items = items::find($inventoris_id);
          $items->stock = $items->stock - $inventorisDetail->total;
          $items->update();

          $inventorisDetail->delete();

              $purchase_count = purchase::where('item_id',$inventoris_id);

              if($purchase_count){
                $total = $purchase_count->count();
                $count = DB::table('purchase')->where('item_id',$inventoris_id)->get();
                try{
                foreach($count as $counting){
                  $modal = $modal + $counting->cost;
                }
                
                $new_modal = $modal / $total;
                }catch (\Exception $e) {
                    $new_modal = 0;
                }
              }else{
                $new_modal = 0;
              }

              $items = items::find($inventoris_id);
              $items->modal = $new_modal;
              $items->update();


          toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Detail Inventoris");

      } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Detail Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
      }
      return redirect()->back();
    }
}
