<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dwij\Laraadmin\Models\Menu;
use DB;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Input;
use App\Models\Role_Menu;


class MenuPermissionController extends Controller
{
    public $show_action = true;
    
    public function __construct()
    {
        $this->menu_id = Menu::get('Menu Permissions');
    }

    public function index()
    {
        $list_values = DB::select("SELECT rm.*,r.name as roleName,lm.name as menuName FROM `role_menu` rm
        inner join roles r on(r.`id`=rm.`role_id`)
        inner join la_menus lm on(lm.`id`=rm.`menu_id`) 
        where rm.deleted_at is null
        order by `role_id` desc,`menu_id` desc");
        $roles = DB::table('roles')
            ->whereNull('deleted_at')
            ->get();
        $menus = DB::table('la_menus')->get();

        if(Menu::hasAccess($this->menu_id)) {
            return View('configuration.menu_permissions.index', [
                'show_actions' => $this->show_action,
                'values'=>$list_values,
                'roles'=>$roles,
                'menus'=>$menus
            ]);
        } else {
            return 'Access Denied';
            //return redirect(config('laraadmin.adminRoute')."/");
        }
    }
    public function store(Request $request){
        if(Menu::hasAccess("Menu Permissions", "create")) {
            $v_cur_date=date("Y-m-d H:i:s");
            $acc_view=$request->input('acc_view');
            if(isset($acc_view)){
                $acc_view=1;
            }else{
                $acc_view=0;
            }
            
            $acc_create=$request->input('acc_create');
            if(isset($acc_create)){
                $acc_create=1;
            }else{
                $acc_create=0;
            }
            $acc_edit=$request->input('acc_edit');
            if(isset($acc_edit)){
                $acc_edit=1;
            }else{
                $acc_edit=0;
            }
            $acc_delete=$request->input('acc_delete');
            if(isset($acc_delete)){
                $acc_delete=1;
            }else{
                $acc_delete=0;
            }
          
            foreach($request->get('role_id') as $role_id)
            {
                foreach($request->get('menu_id') as $menu_id){
                    $role_menu=DB::table('role_menu')
                        ->where('role_id',$role_id)
                        ->where('menu_id',$menu_id)
                        ->whereNull('deleted_at')
                        ->first();
                    if(isset($role_menu->id) && $role_menu->id>0){
                        //......update role menu table....
                        $role_menu = Role_Menu::find($role_menu->id);    
                        $role_menu->acc_view = $acc_view;
                        $role_menu->acc_create = $acc_create;
                        $role_menu->acc_edit = $acc_edit;
                        $role_menu->acc_delete = $acc_delete;
                        $role_menu->updated_at = $v_cur_date;
                        $role_menu->save();

                        // $role_menu_data=[
                        // 'acc_view' => $acc_view, 
                        // 'acc_create' => $acc_create,
                        // 'acc_edit' => $acc_edit,
                        // 'acc_delete' => $acc_delete,
                        // 'updated_at'=>$v_cur_date];

                        // DB::table('role_menu')
                        //     ->where('id', $role_menu->id)
                        //     ->update($role_menu_data);
                    }else{
                        //......insert role menu table....
                        $role_menu = new Role_Menu;
                        $role_menu->role_id = $role_id;
                        $role_menu->menu_id = $menu_id;
                        $role_menu->acc_view = $acc_view;
                        $role_menu->acc_create = $acc_create;
                        $role_menu->acc_edit = $acc_edit;
                        $role_menu->acc_delete = $acc_delete;
                        $role_menu->created_at = $v_cur_date;
                        $role_menu->save();

                        // $role_menu_data=['role_id' => $role_id, 
                        // 'menu_id' => $menu_id,
                        // 'acc_view' => $acc_view, 
                        // 'acc_create' => $acc_create,
                        // 'acc_edit' => $acc_edit,
                        // 'acc_delete' => $acc_delete,
                        // 'created_at'=>$v_cur_date];
                        // DB::table('role_menu')->insert($role_menu_data);
                    }    
                }
            }
            return redirect()->route(config('laraadmin.adminRoute') . '.menu_permissions.index');
        }else{
            return 'Access Denied';
        }
        
        // print($role_id);die();
        // echo 'sdfsf';die();
    }
    public function action(Request $request){
        $id=$request->input('role_menu_id');
        $role_menu = Role_Menu::find($id);

        $delete=$request->input('delete');
        if(isset($delete) && $delete=='1'){
            if(Menu::hasAccess("Menu Permissions", "delete")) {
                $role_menu->delete();
            }else{
                return 'Access Denied';
            }
        }else{
            if(Menu::hasAccess("Menu Permissions", "edit")) {
                $acc_view=$request->input('acc_view');
                if(isset($acc_view)){
                    $acc_view=1;
                }else{
                    $acc_view=0;
                }
                $acc_create=$request->input('acc_create');
                if(isset($acc_create)){
                    $acc_create=1;
                }else{
                    $acc_create=0;
                }
                $acc_edit=$request->input('acc_edit');
                if(isset($acc_edit)){
                    $acc_edit=1;
                }else{
                    $acc_edit=0;
                }
                $acc_delete=$request->input('acc_delete');
                if(isset($acc_delete)){
                    $acc_delete=1;
                }else{
                    $acc_delete=0;
                }
                $role_menu->acc_view =$acc_view;
                $role_menu->acc_create =$acc_create;
                $role_menu->acc_edit =$acc_edit;
                $role_menu->acc_delete =$acc_delete;
                $role_menu->save();
            }else{
                return 'Access Denied';
            }
            
        }
        return redirect()->route(config('laraadmin.adminRoute') . '.menu_permissions.index');

    }

}