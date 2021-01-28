<?php

namespace App\Http\Controllers\backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\items;
use App\Models\type;
use App\Models\brands;
use App\Models\units;
use App\Models\suppliers;
use App\Models\purchase;
use App\User;
use Sentinel;
use App\Http\Resources\inventorisList as inlist;

class itemController extends Controller
{
    public function index(Request $request)
    {
        try {
        $brands = brands::pluck('name','id');
        $units = units::pluck('name','id');
        $type = type::pluck('name','id');
        return view('backend.item.index',compact('brands','units','type'));
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        $brands = brands::pluck('name','id');
        $units = units::pluck('name','id');
        $type = type::pluck('name','id');
        return view('backend.item.create',compact('brands','units','type'));
    }

    public function show($id)
    {

        $data = items::find($id);
        if(Sentinel::getUser()->hasAccess(['item.self-data'])){
        if(!$data){
            toast()->error('Data Not Found', 'Eror');
            return redirect()->back();
        }
        }
        $brands = brands::pluck('name','id');
        $units = units::pluck('name','id');
        $type = type::pluck('name','id');
        $suppliers = suppliers::select('suppliers.id','suppliers.name')->where('suppliers.id','<>',1)->get();

        if($suppliers->count()>0){
        $suppliers = $suppliers->pluck('name','id')->union(['xxx'=>'Lainnya']);
        }

        return view('backend.item.showDinkes',compact('brands','suppliers','units','type','data'));

    }

    public function store(Request $request)
    {
    try {
            $items = new items;
            $items->name = $request->name;
            $items->brand_id = $request->brands;
            $items->unit_id = $request->units;
            $items->type_id = $request->type;
            $items->price = $request->profit;
            $items->note = $request->note;

            if ($request->hasFile('avatar') && $request->avatar->isValid()) {
                $path = config('value.img_path.avatar');
                $oldfile = $items['picture'];
                $fileext = $request->avatar->extension();
                $filename = "avatars-".$items['name'].'-'.$items['unit_id'].'.'.$fileext;
                //Real File
                $filepath = $request->file('avatar')->storeAs($path, $filename, 'local');
                //Avatar File
                $realpath = storage_path('app/'.$filepath);

                $items['picture'] = $filename;
            }

            $items->save();
        

        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah inventoris");
        return redirect("item");
    } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->withInput();
    }
    }

    public function update(Request $request, $id)
    {
    try {

        $request->validate([
            'units' => 'required',
            'brands' => 'required'
        ]);

        $items = items::find($id);
        
        if(!$items){
        toast()->error('Data Not Found', 'Eror');
        return redirect()->back();
        }

        if ($request->hasFile('avatar') && $request->avatar->isValid()) {
            $path = config('value.img_path.avatar');
            $oldfile = $items['picture'];
            $fileext = $request->avatar->extension();
            $filename = "avatars-".$items['name'].'-'.$items['unit_id'].'.'.$fileext;
            //Real File
            $filepath = $request->file('avatar')->storeAs($path, $filename, 'local');
            //Avatar File
            $realpath = storage_path('app/'.$filepath);

            $items['picture'] = $filename;
        }

        $items->name = $request->name;
        $items->brand_id = $request->brands;
        $items->unit_id = $request->units;
        $items->type_id = $request->type;
        $items->price= $request->profit;
        $items->note= $request->note;
 
        $items->update();

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
    $items = "";
    try {
        $items = items::find($id);

        if(!$items){
            toast()->error('Data Not Found', 'Eror');
            return redirect()->back();
        }

        $items->delete();
        toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Inventoris");

    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Inventoris | error : ".$e->getMessage());
        toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
    }

    return redirect("item");
    }

    public function getData(Request $request)
    {

    try {
    $data = [];
    //?data=all&status=
    if($request->data=="all"){
        $data = items::orderby('id','desc')->get();
    }
    //?data=&id=
    elseif($request->data=="id"){
        $data = items::find($request->id);
    }

    if($data)return response()->json(inlist::collection($data));
    return $data;
    } catch (\Exception $e) {
    return [];
    }
    }

   
}
