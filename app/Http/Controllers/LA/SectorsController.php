<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Lang;
use Session;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Sector;

class SectorsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $websites;
	public $projects;
	public $listing_cols = ['id', 'website_id', 'name', 'bn_name', 'project_id', 'is_show'];
	
	public function __construct() {

        $this->projects= Project::get();
        $this->websites= Website::whereIn('id',[1,2])->get();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Sectors', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Sectors', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Sectors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Sectors');
		if(Menu::hasAccess('Sectors')) {
			return View('la.sectors.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'websites' => $this->websites,
				'projects' => $this->projects,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new sector.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created sector in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Sectors", "create")) {

            $sectors = Sector::orderBy('id', 'desc')->get();

            /*Check name for website wize unique*/
            $Check_sectors = Sector::where('website_id',$request->website_id)->get();
            $website=Website::find($request->website_id);
            if ($Check_sectors->contains('name', $request->name)){
                $mgs=$request->name." is already taken under this website ".$website->name;
                return redirect()->back()->withInput()->withErrors(['errors' => $mgs]);
            }elseif ($Check_sectors->contains('bn_name', $request->bn_name)){
                $mgs=$request->bn_name." is already taken under this website ".$website->name;
                return redirect()->back()->withInput()->withErrors(['errors' => $mgs]);
            }
            /*Check name for website wize unique End */


            $serial_no = $sectors->max('serial_no') + 1;
		
			$rules = Module::validateRules("Sectors", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
            $request->request->add(['serial_no' => $serial_no]);
            Sector::create($request->all());
			//$insert_id = Module::insert("Sectors", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sectors.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified sector.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Sectors", "view")) {
			
			$sector = Sector::find($id);
			if(isset($sector->id)) {
				$module = Module::get('Sectors');
				$module->row = $sector;
				
				return view('la.sectors.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('sector', $sector);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sector"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified sector.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Sectors", "edit")) {			
			$sector = Sector::find($id);
			if(isset($sector->id)) {	
				$module = Module::get('Sectors');
				
				$module->row = $sector;
				
				return view('la.sectors.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
                    'websites' => $this->websites,
                    'projects' => $this->projects,
				])->with('sector', $sector);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sector"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified sector in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Sector $sectors)
	{
		if(Menu::hasAccess("Sectors", "edit")) {

			$rules = Module::validateRules("Sectors", $request, true);

            /*Check name for website wize unique*/
            $check_sectors = Sector::where('website_id',$request->website_id)->where('id', '!=', $sectors->id)->get();
            $website=Website::find($request->website_id);

                if ($check_sectors->contains('name', $request->name)){
                    $mgs=$request->name." is already taken under this website ".$website->name;
                    return redirect()->back()->withInput()->withErrors(['errors' => $mgs]);
                }elseif ($check_sectors->contains('bn_name', $request->bn_name)){
                    $mgs=$request->bn_name." is already taken under this website ".$website->name;
                    return redirect()->back()->withInput()->withErrors(['errors' => $mgs]);
                }
            /*Check name for website wize unique End */

			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
            $sectors->update($request->all());
			//$insert_id = Module::updateRow("Sectors", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sectors.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified sector from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Sectors", "delete")) {
			Sector::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sectors.index');
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
		$values = DB::table('sectors')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Sectors');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/sectors/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Sectors", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/sectors/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Sectors", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.sectors.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

    public function sectorOrder()
    {
        if (Menu::hasAccess('Sectors')) {
            $sectors = Sector::orderBy('serial_no','asc')->get();
            return View('la.sectors.order',['sectors'=>$sectors]);
        } else {
            return View('error');
        }
    }

    public function sectorOrderUpdate(Request $request)
    {
        $sectors = Sector::orderBy('id','desc')->get();
        foreach ($sectors as $sector) {
            $sector->timestamps = false;
            $id = $sector->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $sector->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
