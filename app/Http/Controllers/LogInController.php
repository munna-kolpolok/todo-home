<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class LogInController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index()
    {
        
    }
    public function logIn(Request $request){
        //print_r($request->all());die();
        $user_name = $request->input('user_name');
        $user_password = $request->input('user_password');


        //$rules = validateRules("Battalions", $request);
            
        //$validator = Validator::make($request->all(), $rules);
        
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        
        //$insert_id = Module::insert("Battalions", $request);
        
        //return redirect()->route(config('laraadmin.adminRoute') . '.battalions.index');

        $user = DB::table('sys_user')->where('user_name', $user_name)
                    ->where('user_password', $user_password)
                    ->count();
        if($user>0){
            //return redirect('home/dashboard');
            //return redirect('LA/DashboardController@index');
            return redirect(config('laraadmin.adminRoute')."/dashboard");
            
        }else{
            //return redirect('dashboard');
            return 'wrong';
        }
        //echo $user;die();


    }
}