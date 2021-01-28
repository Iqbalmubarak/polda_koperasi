<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Role;
use App\Models\suppliers;
use Sentinel;
use Route;

class supplierController extends Controller
{
  public function index(Request $request)
  {
    try {
      return view('backend.supplier.index');
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
                    if(suppliers::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                      toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                      $fail($attribute.' sudah ada sebelumnya.');
                    }
                }]
    ]);
    try {
        $supplier = new suppliers;
        $supplier->name = $request->name;
        $supplier->alamat = $request->address;
        $supplier->save();
        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));

        return redirect()->route('supplier.index');
    } catch (\Exception $e) {
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Satuan Barang | error : ".$e->getMessage());
        return redirect()->back();
    }
  }


  public function show($id)
  {
    try {
      $users = null;
      if($id){
          $role = Sentinel::findRoleBySlug($id);
          $users = $role->users()::paginate(8);
      }
      return view('backend.user.index',compact('users'));

    } catch (\Exception $e) {
        toast()->error($e->getMessage(), 'Eror');
        return redirect()->back();
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $request->validate([
          'name' => 'required'
      ]);

      if(supplier::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->where('id','<>',$id)->first()){
          $request->validate([
              'name' => [function ($attribute, $value, $fail) {
                            if(supplier::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                              toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                              $fail($attribute.' sudah ada sebelumnya.');
                            }
                        }]
          ]);
      }
      $supplier = suppliers::find($id);
      $supplier->name = $request->name;
      $supplier->alamat = $request->address;
      $supplier->save();
      toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
 
      return redirect()->route('supplier.index');
    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit Satuan Barang | error : ".$e->getMessage());
        toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
        return redirect()->back();
    }
  }


  public function destroy($id)
    {
      try {        
          $supplier = suppliers::find($id);
          $supplier->delete();
          toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
            
      } catch (\Exception $e) {
           toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
      }
      return redirect()->back();
    }
  
  public function permissions($id)
  {
    try {
      $role = Sentinel::findRoleById($id);
      $routes = Route::getRoutes();

      $actions = [];
      foreach ($routes as $route) {
          if ($route->getName() != "" && !substr_count($route->getName(), 'payment')) {
              $actions[] = $route->getName();
          }
      }
      //remove store option
      $input = preg_quote("store", '~');
      $var = preg_grep('~' . $input . '~', $actions);
      $actions = array_values(array_diff($actions, $var));

      //remove update option
      $input = preg_quote("update", '~');
      $var = preg_grep('~' . $input . '~', $actions);
      $actions = array_values(array_diff($actions, $var));

      $var = [];
      $i = 0;
      foreach ($actions as $action) {
          $input = preg_quote(explode('.', $action )[0].".", '~');
          if(count(explode('.', $action )) > 1 ){
            if(preg_quote(explode('.', $action )[1], '~') == 'index' || preg_quote(explode('.', $action )[1], '~') == 'dashboard'){
              $op = preg_quote(explode('.', $action )[0], '~');
              $op = str_replace("\-","-",$op);
              array_push($actions,$op.'.all-data', $op.'.part-data',$op.'.self-data');
            }
          }
          $var[$i] = preg_grep('~' . $input . '~', $actions);
          $actions = array_values(array_diff($actions, $var[$i]));
          $i += 1;
      }

      $actions = array_filter($var);
      // $add = 'log-viewer::logs.dashboard';
      // array_push($actions[1],$add);
      return View('backend.roles.permission', compact('role', 'actions'));
    } catch (\Exception $e) {
      toast()->error($e->getMessage(), 'Eror');
      toast()->error('Terjadi Eror Saat Meng-Load Permission, Silakan Ulang Login kembali', 'Gagal');
      return redirect()->back();
    }
  }

  public function simpan($id, Request $request)
  {
    try {
      $role = Sentinel::findRoleById($id);
      $role->permissions = [];
      if($request->permissions){
          foreach ($request->permissions as $permission) {
              if(explode('.', $permission)[1] == 'create'){
                  $role->addPermission($permission);
                  $role->addPermission(explode('.', $permission)[0].".store");
              }
              else if(explode('.', $permission)[1] == 'edit'){
                  $role->addPermission($permission);
                  $role->addPermission(explode('.', $permission)[0].".update");
              }
              else{
                  $role->addPermission($permission);
              }
          }
      }
      $role->save();
      toast()->success('Berhasil Menyimpan Role', 'Berhasil');
      return redirect()->route('roles.index');
    } catch (\Exception $e) {
      toast()->error($e->getMessage(), 'Eror');
      toast()->error('Terjadi Eror Saat Meng-Nyimpan Permission, Silakan Ulang Login kembali', 'Gagal');
      return redirect()->back();
    }
  }

  public function getData(Request $request)
  {
      $data = [];
      //?data
      if($request->data=="all"){
        $data = suppliers::orderby('id','desc')->get();
      }
      //?data=&id=
      elseif($request->data=="id"){
        $data = suppliers::find($request->id);
      }

      return response()->json($data);
  }

  public function permissionGetData(Request $request)
  {
      $data = false;

      // ?data=permission&permission=
      if($request->data=="permission"){
        $data = Sentinel::getUser()->hasAccess($request->permission);
      }
      // ?data=aplikasi&aplikasi=
      elseif($request->data=="aplikasi"){
        $id = $request->aplikasi;
        $data = Sentinel::getUser()->myapps()->where('aplikasi_id',$id)->where('status',1)->get()->isNotEmpty();
      }

      return ['data'=>$data];
  }
   
  
 


}
