<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dwij\Laraadmin\Models\Menu;
use DB;
use Validator;
use Lang;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Input;
use App\Models\Employee_Info;
use Response;
use App\Helpers\CommonHelper;

use App\Models\Issue_Item;

use Session;


class CommonController extends Controller
{
    
    
    public function __construct()
    {
        
    }

    public function index()
    {
        
    }
  
    public function common_dynamic_load_dropdown(Request $request)
    {
        $child_table_name=$request->input('child_table_name');
        $parent_id_name=$request->input('parent_id_name');
        $parent_id=$request->input('parent_id');
        $result = DB::table($child_table_name)
                    ->where($parent_id_name,$parent_id)
                    ->whereNull('deleted_at')
                    ->get();
        return Response::json($result);
    }
    public function common_dropdown(Request $request)
    {
        $table_name=$request->table_name;
        $result = DB::table($table_name)
                    ->whereNull('deleted_at')
                    ->get();
        return Response::json($result);
    }
    public function common_dynamic_load_dropdown_from_date_to_to_date(Request $request)
    {
        $currentMonth = date('m');
        $child_table_name=$request->input('child_table_name');
        $parent_id_name=$request->input('parent_id_name');
        $parent_id=$request->input('parent_id');
        $result = DB::table($child_table_name)
            ->select(DB::raw('*,concat(DATE_FORMAT(from_date, "%d/%m/%Y")," to ",
                date_format(to_date, "%d/%m/%Y")) as from_date_to_to_date
                '))
            ->where($parent_id_name,$parent_id)
            ->whereRaw('MONTH(from_date) = ?',[$currentMonth])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return Response::json($result);
    }


    public function rank_wise_designation_list(Request $request)
    {
        $result=DB::table('designation_mappings as dm')
            ->join('designations as d','d.id','=','dm.designation_id')
            ->select('d.id','d.designation_name','d.desig_short_name')
            ->where('dm.rank_id',$request->rank_id)
            ->whereNull('dm.deleted_at')
            ->whereNull('d.deleted_at')
            ->get();
        return Response::json($result);
    }
    
    //.................Inventory start................
    public function ledger_balance_check(Request $request)
    {
        $result=[];
        $ledger=DB::table('ledgers')
            ->where('organization_store_id',$request->organization_store_id)
            ->where('item_id',$request->item_id)
            ->whereNull('deleted_at')
            ->first();
        if(empty($ledger))
        {
            $result['msg']=Lang::get('messages.Item stock is not available');
        }
        else
        {
            $svc_qty=($request->svc_qty) ? $request->svc_qty : 0;
            $repairable_qty=($request->repairable_qty) ? $request->repairable_qty : 0;  
            $unrepairable_qty=($request->unrepairable_qty) ? $request->unrepairable_qty : 0; 

            $v_ledger_svc_qty=$ledger->svc_qty+$ledger->private_svc_qty;
            $v_ledger_repairable_qty=$ledger->repairable_qty+$ledger->private_repairable_qty;
            $v_ledger_unrepairable_qty=$ledger->unrepairable_qty+$ledger->private_unrepairable_qty;
            
            if($svc_qty>$v_ledger_svc_qty)
            {
                $result['msg']=Lang::get('messages.svc item stock is not available') . CommonHelper::round_number_format($v_ledger_svc_qty);
            }
            else if($repairable_qty>$v_ledger_repairable_qty)
            {
                $result['msg']=Lang::get('messages.Repairable item stock is not available') . CommonHelper::round_number_format($v_ledger_repairable_qty);
            }
            else if($unrepairable_qty>$v_ledger_unrepairable_qty)
            {
                $result['msg']=Lang::get('messages.Unrepairable item stock is not available') . CommonHelper::round_number_format($v_ledger_unrepairable_qty);
            }
        }    
        
        return Response::json($result);     

    }

    public function ledger_balance_check_edit(Request $request)
    {
        $result=[];
        $ledger=DB::table('ledgers')
            ->where('organization_store_id',$request->organization_store_id)
            ->where('item_id',$request->item_id)
            ->whereNull('deleted_at')
            ->first();
        if(empty($ledger))
        {
            $result['msg']=Lang::get('messages.Item stock is not available');
        }
        else
        {
            $issue_item=Issue_Item::where('issue_id',$request->issue_id)
                 ->where('item_id',$request->item_id)
                 ->first();

            $svc_qty=($request->svc_qty) ? $request->svc_qty : 0;
            $repairable_qty=($request->repairable_qty) ? $request->repairable_qty : 0;  
            $unrepairable_qty=($request->unrepairable_qty) ? $request->unrepairable_qty : 0; 

            if(empty($issue_item))
            {
                $issue_item_svc_qty=0;
                $issue_item_repairable_qty=0;
                $issue_item_unrepairable_qty=0;
            }
            else
            {
                $issue_item_svc_qty=$issue_item->svc_qty;
                $issue_item_repairable_qty=$issue_item->repairable_qty;
                $issue_item_unrepairable_qty=$issue_item->unrepairable_qty;
            }

            $v_ledger_svc_qty=$ledger->svc_qty+$ledger->private_svc_qty+$issue_item_svc_qty;
            $v_ledger_repairable_qty=$ledger->repairable_qty+$ledger->private_repairable_qty+$issue_item_repairable_qty;
            $v_ledger_unrepairable_qty=$ledger->unrepairable_qty+$ledger->private_unrepairable_qty+$issue_item_unrepairable_qty;
            
            if($svc_qty>$v_ledger_svc_qty)
            {
                $result['msg']=Lang::get('messages.svc item stock is not available') . CommonHelper::round_number_format($v_ledger_svc_qty);
            }
            else if($repairable_qty>$v_ledger_repairable_qty)
            {
                $result['msg']=Lang::get('messages.Repairable item stock is not available') . CommonHelper::round_number_format($v_ledger_repairable_qty);
            }
            else if($unrepairable_qty>$v_ledger_unrepairable_qty)
            {
                $result['msg']=Lang::get('messages.Unrepairable item stock is not available') . CommonHelper::round_number_format($v_ledger_unrepairable_qty);
            }
        }    
        
        return Response::json($result);     

    }


    public static function user_wise_store_list(Request $request)
    {
        $org_info=DB::table('users as u')
            ->join('employees_info as ei','ei.user_id','=','u.id')
            ->join('posting_record as pr','pr.posting_rec_id','=','ei.posting_rec_id')
            ->select('pr.*')
            ->where('u.id',$request->user_id)
            ->whereNull('u.deleted_at')
            ->whereNull('ei.deleted_at')
            ->whereNull('pr.deleted_at')
            ->first();

        $result=DB::table('organization_stores')
            ->join('stores', 'stores.id', '=', 'organization_stores.store_id')
            ->select('organization_stores.id','stores.store_name')
            ->where('battalion_id',$org_info->battalion_id ? $org_info->battalion_id : null)
            ->where('wing_id',$org_info->wing_id ? $org_info->wing_id : null)
            ->where('branch_id',$org_info->branch_id ? $org_info->branch_id : null)
            ->where('sub_branch_id',$org_info->sub_branch_id ? $org_info->sub_branch_id : null)
            ->where('section_id',$org_info->section_id ? $org_info->section_id : null)
            ->where('sub_section_id',$org_info->sub_section_id ? $org_info->sub_section_id : null)
            ->whereNull('organization_stores.deleted_at')
            ->whereNull('stores.deleted_at')
            ->get();

        return Response::json($result);    

    }
    public function org_wise_store_list(Request $request)
    {
        
        if(empty($request->edit_org_store_id))
        {
            $result=DB::table('organization_stores')
            ->join('stores', 'stores.id', '=', 'organization_stores.store_id')
            ->select('organization_stores.*','stores.store_name')
            ->where('battalion_id',$request->battalion_id ? $request->battalion_id : null)
            ->where('wing_id',$request->wing_id ? $request->wing_id : null)
            ->where('branch_id',$request->branch_id ? $request->branch_id : null)
            ->where('sub_branch_id',$request->sub_branch_id ? $request->sub_branch_id : null)
            ->where('section_id',$request->section_id ? $request->section_id : null)
            ->where('sub_section_id',$request->sub_section_id ? $request->sub_section_id : null)
            ->whereNull('organization_stores.deleted_at')
            ->whereNull('stores.deleted_at')
            ->get();
        }
        else
        {
             $result=DB::table('organization_stores')
            ->join('stores', 'stores.id', '=', 'organization_stores.store_id')
            ->select('organization_stores.*','stores.store_name')
            ->where('organization_stores.id',$request->edit_org_store_id)
            ->whereNull('organization_stores.deleted_at')
            ->whereNull('stores.deleted_at')
            ->get();  
        }
        return Response::json($result);
    }
    public function org_store_wise_category_list(Request $request)
    {
        $result=DB::table('assign_store_items as ast')
            ->join('item_categories as ic','ic.id','=','ast.item_cat_id')
            ->select('ic.id','ic.item_cat_name','ic.item_cat_code')
            ->where('ast.org_store_id',$request->org_store_id)
            ->whereNull('ast.deleted_at')
            ->whereNull('ic.deleted_at')
            ->get();
        return Response::json($result);
    }
    public function category_wise_group_list(Request $request)
    {
        $item_cat_id = $request->item_cat_id;
        if(empty($item_cat_id)){
            $result=DB::table('item_groups')
                ->select('id','item_group_name')
                ->whereNull('deleted_at')
                ->get();
        }else{
            $result=DB::table('item_groups')
                ->select('id','item_group_name')
                ->where('item_cat_id',$request->item_cat_id)
                ->whereNull('deleted_at')
                ->get();
        }
        return Response::json($result);
    }
    public function category_and_group_wise_item_list(Request $request)
    {
        $item_cat_id=$request->item_cat_id;
        $item_group_id=$request->item_group_id;
        if(empty($item_group_id))
        {
            $result=DB::table('items')
            ->select('id','item_name')
            ->where('item_cat',$item_cat_id)
            ->whereNull('deleted_at')
            ->get();
        }
        else
        {
            $result=DB::table('items')
            ->select('id','item_name')
            ->where('item_cat',$item_cat_id)
            ->where('item_group',$item_group_id)
            ->whereNull('deleted_at')
            ->get();
        } 
        return Response::json($result);   
    }
    public function item_info(Request $request)
    {
        $result=DB::table('items')
        ->where('id',$request->item_id)
        ->whereNull('deleted_at')
        ->first();
        return Response::json($result); 
    }
    public function measurement_unit_list()
    {
        $result=DB::table('measurement_units')
            ->select('id','mm_unit_name','mm_unit_code')
            ->whereNull('deleted_at')
            ->get();
        return Response::json($result);  
    }
    public function item_wise_measurement_unit_list(Request $request)
    {
        $result=DB::table('items as i')
        ->join('measurement_units as mu','i.mm_unit_id','=','mu.id')
        ->select('mu.id','mu.mm_unit_name','mu.mm_unit_code')
        ->where('i.id',$request->item_id)
        ->whereNull('i.deleted_at')
        ->whereNull('mu.deleted_at')
        ->first();
        return Response::json($result); 
    }
    public function iv_item_info(Request $request)
    {
        $item_id=$request->item_id;
        $issue_voucher_id=$request->issue_voucher_id;
        $result=DB::table('issue_items')
            ->where('issue_id',$issue_voucher_id)
            ->where('item_id',$item_id)
            ->whereNull('deleted_at')
            ->first();
        return Response::json($result);     
    }
    //.................Inventory end................

    public function get_emp_info(Request $request){
        $emp_id=$request->input('emp_id');
        $employee_info = DB::SELECT("SELECT ei.*,mf.mf_name,c.core_name,t.trade_name,mu.mu_name,r.rank_name,d.designation_name 
            FROM `employees_info` ei
            left join mother_forces mf on(mf.id=ei.`mother_force_id`)
            left join cores c on(c.id=ei.`core_id`)
            left join trades t on(t.id=ei.`trade_id`)
            left join mother_units mu on(mu.id=ei.`mother_unit_id`)
            left join ranks r on(r.id=ei.`rank_id`)
            left join designations d on(d.id=ei.`designation_id`)
            WHERE ei.`emp_id`=$emp_id")[0];
                            
        return Response::json($employee_info);
    }

    public function get_vehicle_info(Request $request){
        $vehicle_record_id = $request->input('vehicle_record_id');
        // $vehicle_info = DB::SELECT("SELECT vi.*, vd.id AS vehicle_driver_id, vd.emp_id, ei.rab_id FROM vehicle_infos vi 
        //     INNER JOIN vehicle_drivers vd ON vi.vehicle_record_id = vd.vehicle_record_id
        //     INNER JOIN employees_info ei ON vd.emp_id = ei.emp_id
        //     WHERE vi.vehicle_record_id = $vehicle_record_id AND vi.deleted_at IS NULL AND vd.deleted_at IS NULL AND ei.deleted_at IS NULL ORDER BY vd.id DESC LIMIT 1")[0];

        $vehicle_info = DB::table('vehicle_drivers as vd')
                ->join('posting_record as pr', 'vd.posting_rec_id', '=', 'pr.posting_rec_id')
                ->join('employees_info as ei', 'pr.emp_id', '=', 'ei.emp_id')
                // ->join('kpl_info as kpl', 'vd')
                ->select('vd.id AS vehicle_driver_id', 'ei.emp_id', 'ei.rab_id')
                ->where('vd.vehicle_record_id', $vehicle_record_id)
                ->whereNull('vd.to_date')
                ->whereNUll('vd.deleted_at')
                ->whereNUll('ei.deleted_at')
                ->whereNUll('pr.deleted_at')
                ->orderBy('vd.id','desc')
                ->first();

        return Response::json($vehicle_info);
    }

    public function category_wise_parts_list(Request $request)
    {
        $result=DB::table('parts')
            ->select('id','parts_name')
            ->where('parts_cat_id',$request->parts_cat_id)
            ->whereNull('deleted_at')
            ->get();
        return Response::json($result);
    }

    public function brand_wise_model_list(Request $request)
    {
        $result=DB::table('vehicle_models')
            ->select('id','model_name')
            ->where('brand_id',$request->brand_id)
            ->whereNull('deleted_at')
            ->get();
        return Response::json($result);
    }


    public function get_daily_vehicle_usage_record(Request $request)
    {
        $vehicle_record_id = $request->input('vehicle_record_id');
        $vehicle_usg_rec = DB::table("daily_vehicle_usages as dvusg")
                                ->select('dvusg.last_meter as prevmeter', 'prev_amount','given_amount','spent_amount')
                                ->where('dvusg.vehicle_record_id', $vehicle_record_id)
                                ->whereNull('deleted_at')
                                ->latest()
                                ->first();
                            
        return Response::json($vehicle_usg_rec);
    }
    /**
     * [battalion_wise_employee_list description]
     * @param  Request $request battalion_id, branch_id, section_id, sub_branch_id, sub_section_id, wing_id 
     * @return [type]           [description]
     */
    public function battalion_wise_employee_list(Request $request)
    {
        if($request->battalion_id == 1 && !empty($request->wing_id)){
            // $result=DB::table('employees_info')
            //                 ->join('posting_record', 'posting_record.posting_rec_id', '=', 'employees_info.posting_rec_id')
            //                 ->select('employees_info.rab_id','posting_record.posting_rec_id')
            //                 ->where('battalion_id',$request->battalion_id ? $request->battalion_id : null)
            //                 ->where('posting_record.wing_id',$request->wing_id ? $request->wing_id : null)
            //                 ->whereNull('employees_info.deleted_at')
            //                 ->whereNull('posting_record.deleted_at')
            //                 ->get();      

            $v_query="and pr.`battalion_id`=$request->battalion_id and pr.wing_id=$request->wing_id";
        }else{
            // $result=DB::table('employees_info')
            //                 ->join('posting_record', 'posting_record.posting_rec_id', '=', 'employees_info.posting_rec_id')
            //                 ->select('employees_info.rab_id','posting_record.posting_rec_id')
            //                 ->where('battalion_id',$request->battalion_id ? $request->battalion_id : null)
            //                 ->whereNull('employees_info.deleted_at')
            //                 ->whereNull('posting_record.deleted_at')
            //                 ->get();

            $v_query="and pr.`battalion_id`=$request->battalion_id";
        }

        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        where ei.deleted_at is null
        $v_query
        ");
        return Response::json($result);

    }
    public function filter_wise_employee_list(Request $request)
    {
        $battalion_id=$request->battalion_id;
        $wing_id=$request->wing_id;
        $branch_id=$request->branch_id;
        $sub_branch_id=$request->sub_branch_id;
        $section_id=$request->section_id;
        $sub_section_id=$request->sub_section_id;
        if($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0 && $section_id>0 && $sub_section_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id
        and pr.section_id=$section_id and pr.sub_section_id=$sub_section_id";
        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0 && $section_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id
        and pr.section_id=$section_id";

        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id";
        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id";
        }
        elseif($battalion_id>0 && $wing_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id";
        }
        elseif($battalion_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id";
        }
        else
        {
            $v_query=NULL;
        }


        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id,ei.emp_id,ei.emp_name
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        where ei.deleted_at is null
        $v_query
        ");
        return Response::json($result);
    }

    public function designation_wise_employee_list(Request $request)
    {
        //echo 'munna';die();
        $battalion_id=$request->battalion_id;
        $wing_id=$request->wing_id;
        $designation_id=$request->designation_id;
        //echo $designation_id;die();
        
        if($battalion_id>0 && $wing_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id";
        }
        elseif($battalion_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id";
        }
        else
        {
            $v_query=NULL;
        }


        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id,ei.emp_id,ei.emp_name
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.posting_rec_id=pr.posting_rec_id)
        where ei.deleted_at is null
        and ei.designation_id='$designation_id'
        $v_query
        ");
        return Response::json($result);

    }

    public function filter_visiting_card(Request $request)
    {
        $battalion_id=$request->battalion_id;
        $wing_id=$request->wing_id;
        
        if($battalion_id>0 && $wing_id>0)
        {
            $v_query="and v.`battalion_id`=$battalion_id and v.wing_id=$wing_id";
        }
        elseif($battalion_id>0)
        {
            $v_query="and v.`battalion_id`=$battalion_id";
        }

        $result=DB::SELECT("SELECT `id`,`card_no` 
        FROM `visiting_cards` v
        WHERE v.`deleted_at` is null
        and v.card_status='1'
        $v_query
        ");

        return Response::json($result);
    }

    public function payroll_hrm_employee_list(Request $request)
    {
        //echo 'hello i am';die();
        $battalion_id=$request->battalion_id;
        $wing_id=$request->wing_id;
        $branch_id=$request->branch_id;
        $sub_branch_id=$request->sub_branch_id;
        $section_id=$request->section_id;
        $sub_section_id=$request->sub_section_id;

        if(isset($request->is_officer))
        {
           $is_officer=$request->is_officer;
        }
        else
        {
            $is_officer=0;
        }

        if(isset($request->is_afd))
        {
           $is_afd=$request->is_afd;
           $v_is_afd_join="inner join mother_forces mf on(mf.id=ei.mother_force_id)";
           $v_is_afd_condition="and mf.is_afd='$request->is_afd'
           and mf.deleted_at is null";
        }
        else
        {
            $v_is_afd_join=null;
            $v_is_afd_condition=null;
        }
        

        if($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0 && $section_id>0 && $sub_section_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id
        and pr.section_id=$section_id and pr.sub_section_id=$sub_section_id";
        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0 && $section_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id
        and pr.section_id=$section_id";

        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0 && $sub_branch_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id and pr.sub_branch_id=$sub_branch_id";
        }
        elseif($battalion_id>0 && $wing_id>0 && $branch_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id 
        and pr.branch_id=$branch_id";
        }
        elseif($battalion_id>0 && $wing_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id";
        }
        elseif($battalion_id>0)
        {
            $v_query="and pr.`battalion_id`=$battalion_id";
        }
        else
        {
            $v_query=NULL;
        }

        if(empty($is_officer))
        {
            // $is_officer_join="inner join ranks r on(r.id=ei.rank_id)";
            // $is_officer_and="and r.is_officer='$is_officer'
            // and r.deleted_at is null";
            $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
            FROM `vw_present_employee_location` pr
            inner join employees_info ei on(ei.emp_id=pr.emp_id)
            inner join payroll_hrm ph on(ph.emp_id=pr.emp_id)
            $v_is_afd_join
            where ei.deleted_at is null
            and ph.deleted_at is null
            $v_query
            $v_is_afd_condition
            group by pr.posting_rec_id
        ");
            
        }
        else
        {
           //echo 'munna';die(); 

            $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
            FROM `vw_present_employee_location` pr
            inner join employees_info ei on(ei.emp_id=pr.emp_id)
            $v_is_afd_join
            inner join payroll_hrm ph on(ph.emp_id=pr.emp_id)
            inner join ranks r on(r.id=ei.rank_id)
            where ei.deleted_at is null
            and ph.deleted_at is null
            and r.is_officer='$is_officer'
            and r.deleted_at is null
            $v_query
            $v_is_afd_condition
            group by pr.posting_rec_id
            ");
        }
        //echo $is_officer_join;die();


        // $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
        // FROM `vw_present_employee_location` pr
        // inner join employees_info ei on(ei.emp_id=pr.emp_id)
        // inner join payroll_hrm ph on(ph.emp_id=pr.emp_id)
        
        // where ei.deleted_at is null
        // and ph.deleted_at is null
        // $v_query
        // group by pr.posting_rec_id
        // ");
        return Response::json($result);
    }

    



    public function item_list(Request $request){
        if($request->item_group_id == 0){
            $result=DB::table('items')
                ->select('id','item_name')                
                ->whereNull('deleted_at')
                ->get();
        }else{
            $result=DB::table('items')
                ->select('id','item_name')
                ->where('item_group', $request->item_group_id)
                ->whereNull('deleted_at')
                ->get();            
        }
        return Response::json($result);
    }

    public function barcode_item_info(Request $request)
    {
        //$request->org_store_id;




        // $result=DB::SELECT("SELECT i.*,ic.item_cat_name,ig.item_group_name,mu.mm_unit_name 
        // FROM `items` i
        // inner join item_categories ic on(ic.id=i.`item_cat`)
        // inner join item_groups ig on(ig.id=i.`item_group`)
        // inner join measurement_units mu on(mu.id=i.`mm_unit_id`)
        // WHERE i.`item_barcode`='$request->item_barcode'
        // and i.`deleted_at` is null
        // and ic.`deleted_at` is null
        // and ig.`deleted_at` is null
        // and mu.`deleted_at` is null")[0];
        // return Response::json($result);

        $result=DB::SELECT("SELECT i.*,ic.item_cat_name,ig.item_group_name,mu.mm_unit_name 
        FROM `items` i
        inner join item_categories ic on(ic.id=i.`item_cat`)
        inner join item_groups ig on(ig.id=i.`item_group`)
        inner join measurement_units mu on(mu.id=i.`mm_unit_id`)
        inner join assign_store_items ast on(ast.item_cat_id=i.`item_cat`)

        WHERE i.`item_barcode`='$request->item_barcode'
        and ast.org_store_id='$request->org_store_id'
        and i.`deleted_at` is null
        and ic.`deleted_at` is null
        and ig.`deleted_at` is null
        and mu.`deleted_at` is null
        and ast.`deleted_at` is null
        ");

        if(count($result)>0)
        {
            $result=$result[0];
        }
        else
        {
            $result=null;
        }

        return Response::json($result);


        

    }

    public function barcode_item_info_report(Request $request)
    {
        //echo 'munna';die();
        if(Session::get('user_level')<2)
        {
            $result=DB::SELECT("SELECT i.*,ic.item_cat_name,ig.item_group_name,mu.mm_unit_name 
            FROM `items` i
            inner join item_categories ic on(ic.id=i.`item_cat`)
            inner join item_groups ig on(ig.id=i.`item_group`)
            inner join measurement_units mu on(mu.id=i.`mm_unit_id`)

            WHERE i.`item_barcode`='$request->item_barcode'
            and i.`deleted_at` is null
            and ic.`deleted_at` is null
            and ig.`deleted_at` is null
            and mu.`deleted_at` is null
            ");

        }
        else
        {
            $user_id=Session::get('user_id');
            $result=DB::SELECT("SELECT i.*,ic.item_cat_name,ig.item_group_name,mu.mm_unit_name
            FROM `items` i
            inner join item_categories ic on(ic.id=i.`item_cat`)
            inner join item_groups ig on(ig.id=i.`item_group`)
            inner join measurement_units mu on(mu.id=i.`mm_unit_id`)
            inner join assign_store_items ast on(ast.item_cat_id=i.`item_cat`)
            inner join store_users su on(su.org_store_id=ast.org_store_id)

            WHERE i.`item_barcode`='$request->item_barcode'
            and su.user_id='$user_id'
            and i.`deleted_at` is null
            and ic.`deleted_at` is null
            and ig.`deleted_at` is null
            and mu.`deleted_at` is null
            and ast.`deleted_at` is null
            and su.`deleted_at` is null
            ");

        }
        

        if(count($result)>0)
        {
            $result=$result[0];
        }
        else
        {
            $result=null;
        }

        return Response::json($result);

    }

}