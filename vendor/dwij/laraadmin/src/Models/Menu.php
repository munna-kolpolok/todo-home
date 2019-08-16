<?php

namespace Dwij\Laraadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Dwij\Laraadmin\Helpers\LAHelper;

use Illuminate\Support\Facades\Auth; 
use DB;

class Menu extends Model
{
    protected $table = 'la_menus';
    
    protected $guarded = [
        
    ];
 //    public static function get($module_name) {
	// 	$module = null;
	// 	if(is_int($module_name)) {
	// 		$module = Module::find($module_name);
	// 	} else {
	// 		$module = Module::where('name', $module_name)->first();
	// 	}
		
	// 	if(isset($module)) {
	// 		$module = $module->toArray();
	// 		$fields = ModuleFields::where('module', $module['id'])->orderBy('sort', 'asc')->get()->toArray();
	// 		$fields2 = array();
	// 		foreach ($fields as $field) {
	// 			$fields2[$field['colname']] = $field;
	// 		}
	// 		$module['fields'] = $fields2;
	// 		return (object)$module;
	// 	} else {
	// 		return null;
	// 	}
	// }

    public static function get($menu_name) {
    	//echo $menu_name;die();
		$menu = null;
		if(is_int($menu_name)) {
			$menu = Menu::find($menu_name);
		} else {
			$menu = Menu::where('name', $menu_name)->first();
		}
		
		if(isset($menu)) {
			// $module = $module->toArray();
			// $fields = ModuleFields::where('module', $module['id'])->orderBy('sort', 'asc')->get()->toArray();
			// $fields2 = array();
			// foreach ($fields as $field) {
			// 	$fields2[$field['colname']] = $field;
			// }
			// $module['fields'] = $fields2;
			// return (object)$module;
			return $menu->id;
		} else {
			return null;
		}
	}

	public static function hasAccess($menu_id, $access_type = "view") {
		//echo $menu_id;die();
		$roles = array();
		if(is_string($menu_id)) {
			$menu = DB::table('la_menus')->where('name', $menu_id)->first();;
			$menu_id = $menu->id;
		}
		
		
		if($access_type == null || $access_type == "") {
			$access_type = "view";
		}
		
		$vUserId = Auth::id();
		$roles  = DB::table('role_users')->where('user_id',$vUserId)->get();

		foreach ($roles as $role) {
			$module_perm = DB::table('role_menu')
				->where('role_id', $role->role_id)
				->where('menu_id', $menu_id)
				->whereNull('deleted_at')
				->first();
			if(isset($module_perm->id)) {
				if(isset($module_perm->{"acc_".$access_type}) && $module_perm->{"acc_".$access_type} == 1) {
					return true;
				} else {
					continue;
				}
			} else {
				continue;
			}
		}
		return false;
	}

}
