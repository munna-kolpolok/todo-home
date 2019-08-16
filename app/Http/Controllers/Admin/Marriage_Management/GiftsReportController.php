<?php

namespace App\Http\Controllers\Admin\Marriage_Management;

use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use Response;
use DB;
use App\Helpers\CommonHelper;

use App\Models\Gift;
use App\Models\Marriage_Profile;


class GiftsReportController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gift_report($id=1)
    {
        if (Menu::hasAccess("Gift_Report")) {
            //echo "string";die();
            $gifts = Gift::orderby('serial_no')->get();
            $marriage_profiles = Marriage_Profile::where('is_verified',1)->get();
            return View('admin.gifts_report.index', [
                'gifts' => $gifts,
                'id' => $id,
                'marriage_profiles'=>$marriage_profiles
            ]);
        } else {
            return View('error');
        }
    }

    public function gift_donor_list(Request $request)
    {
        $donors=DB::SELECT("SELECT p.payment_date,p.payer_email,u.email,u.name,concat(p.payer_first_name,' ',p.payer_last_name) as payer_name,c.currency_name,c.currency_code,od.price,od.`quantity`,o.comments
            FROM `order_details` od 
            inner join orders o on(o.id=od.`order_id`)
            inner join paypal_payments p on(o.id=p.order_id)
            inner join currencies c on(c.id=od.`currency_id`)
            left join users u on(u.id=p.user_id)
            WHERE od.`gift_id`=$request->gift_id
            and o.marriage_id=$request->marriage_id
            and p.state='approved'
            and o.deleted_at is null
            and od.deleted_at is null
            and p.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null
            UNION
            SELECT sp.tran_time as payment_date,sp.cus_email as payer_email,u.email,u.name,sp.cus_name as payer_name,c.currency_name,c.currency_code,od.price,od.`quantity`,o.comments
            FROM `order_details` od 
            inner join orders o on(o.id=od.`order_id`)
            inner join ssl_payments sp on(o.id=sp.order_id)
            inner join currencies c on(c.id=od.`currency_id`)
            left join users u on(u.id=sp.user_id)
            WHERE od.`gift_id`=$request->gift_id
            and o.marriage_id=$request->marriage_id
            and sp.tran_status='Success'
            and o.deleted_at is null
            and od.deleted_at is null
            and sp.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null");

        $v_result=null;
        foreach ($donors as $key => $donor) {
            $v_result.='<tr>
                <td>'.CommonHelper::showDateTimeFormat($donor->payment_date).'</td>
                <td>'.$donor->email.'-'.$donor->name.'</td>
                <td>'.$donor->payer_email.'-'.$donor->payer_name.'</td>
                <td align="center">'.$donor->quantity.'</td>
                <td align="right">'.$donor->price.'</td>
                <td align="right">'.$donor->price*$donor->quantity.'</td>
                <td>'.$donor->currency_name.'</td>
                <td>'.$donor->comments.'</td>
            </tr>';
        } 

        return Response::json($v_result);    

        //echo $request->gift_id;die();
    }

}
