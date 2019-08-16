<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User_Level;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\User;

class UsersController extends Controller
{
	public $show_action = true;
	public $view_col = 'email';
	public $listing_cols = ['id', 'name', 'email','user_level'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Users', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Users', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        $users = User::orderBy('id','desc')->get();
		$levels = User_Level::orderBy('id', 'asc')->get(['id','name']);
		
		if(Menu::hasAccess('Users')) {
			return View('la.users.index', [
				'users' => $users,
				'levels' => $levels,
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created user in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		if(Menu::hasAccess("Users", "create")) {

		    $data = $request->except('password','id_card');
		    $data['password'] = bcrypt($request->password);
			//$insert_id = Module::insert("Users", $request);
			if ($request->has('id_card')) {
                $data['id_card'] = $request->id_card;
            }
            User::create($data);
            Session::flash('message',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.users.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Users", "view")) {
			
			$user = User::find($id);
			if(isset($user->id)) {
				$module = Module::get('Users');
				$module->row = $user;
				
				return view('la.users.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('user', $user);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("user"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Users", "edit")) {			
			$user = User::find($id);
			return view('la.users.edit', compact('user'));
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request, $id)
	{
		if(Menu::hasAccess("Users", "edit")) {
			
            $user = User::find($id);
            $data = $request->except('password','id_card');
            if ($request->has('password')) {
                $data['password'] = bcrypt($request->password);
            }
            if ($request->has('id_card')) {
                $data['id_card'] = $request->id_card;
            }
            $user->fill($data);
            if ($user->isDirty('email')) {
                $this->validate($request,[
                    'email' => 'email|unique:users'
                ]);
            }
            if ($user->isDirty('id_card')) {
                $this->validate($request,[
                    'id_card' => 'unique:users'
                ]);
            }
            $user->update($data);
            Session::flash('message',Lang::get('messages.Updated successfully'));
			return redirect()->route(config('laraadmin.adminRoute') . '.users.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Users", "delete")) {
			User::find($id)->forceDelete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			return redirect()->route(config('laraadmin.adminRoute') . '.users.index');
		} else {
			return View('error');
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('users')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Users');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/users/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Users", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/users/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Users", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.users.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
