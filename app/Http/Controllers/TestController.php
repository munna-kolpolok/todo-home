<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Dwij\Laraadmin\Models\Menu;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu_id = Menu::get('Test 1');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        
        //$menu_id = Menu::get('Test 1');
        
        //echo $this->menu_id;die();
        if(Menu::hasAccess($this->menu_id)) {
            return 'munna';
        } else {
            return 'Access Denied';
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }
}