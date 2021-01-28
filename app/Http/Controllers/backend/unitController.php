<?php

namespace App\Http\Controllers\backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\units;
use App\User;
use Sentinel;

class unitController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('backend.unit.index');
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required',
                    function ($attribute, $value, $fail) {
                        if(units::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                        toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                        $fail($attribute.' sudah ada sebelumnya.');
                        }
                    }]
        ]);
        try {
            $unit = new units;
            $unit->name = $request->name;
            $unit->save();
            toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Satuan Barang");
            return redirect()->route('unit.index');
        } catch (\Exception $e) {
            toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Satuan Barang | error : ".$e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
        $request->validate([
            'name' => 'required'
        ]);

        if(units::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->where('id','<>',$id)->first()){
            $request->validate([
                'name' => [function ($attribute, $value, $fail) {
                                if(units::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                                toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                                $fail($attribute.' sudah ada sebelumnya.');
                                }
                            }]
            ]);
        }
        $unit = units::find($id);
        $unit->name = $request->name;
        $unit->save();
        toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah Satuan Barang");
        return redirect()->route('unit.index');
        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit Satuan Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try {        
            $units = units::find($id);
            $units->delete();
            toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Satuan Barang");

        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di HapusSatuan Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
        }
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $data = [];
        //?data
        if($request->data=="all"){
            $data = units::orderby('id','desc')->get();
        }
        //?data=&id=
        elseif($request->data=="id"){
            $data = units::find($request->id);
        }

        return response()->json($data);
    }
}
