<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Lang;

class Common_Model extends Model
{
    public static function user_wise_store_list($user_id)
    {
        // $org_info=DB::table('users as u')
        //     ->join('employees_info as ei','ei.user_id','=','u.id')
        //     ->join('posting_record as pr','pr.posting_rec_id','=','ei.posting_rec_id')
        //     ->select('pr.*')
        //     ->where('u.id',$user_id)
        //     ->whereNull('u.deleted_at')
        //     ->whereNull('ei.deleted_at')
        //     ->whereNull('pr.deleted_at')
        //     ->first();
        // if(isset($org_info))
        // {
        // 	$result=DB::table('organization_stores')
        //     ->join('stores', 'stores.id', '=', 'organization_stores.store_id')
        //     ->select('organization_stores.id','stores.store_name')
        //     ->where('battalion_id',$org_info->battalion_id ? $org_info->battalion_id : null)
        //     ->where('wing_id',$org_info->wing_id ? $org_info->wing_id : null)
        //     ->where('branch_id',$org_info->branch_id ? $org_info->branch_id : null)
        //     ->where('sub_branch_id',$org_info->sub_branch_id ? $org_info->sub_branch_id : null)
        //     ->where('section_id',$org_info->section_id ? $org_info->section_id : null)
        //     ->where('sub_section_id',$org_info->sub_section_id ? $org_info->sub_section_id : null)
        //     ->whereNull('organization_stores.deleted_at')
        //     ->whereNull('stores.deleted_at')
        //     ->get();

        // 	return $result;  
        // }
        // else
        // {
        // 	return false;
        // }   


        if($user_id>0)
        {
            return DB::SELECT("SELECT os.id,s.store_name
            FROM  `store_users` su
            INNER JOIN organization_stores os ON ( os.id = su.`org_store_id` ) 
            INNER JOIN stores s ON ( s.id = os.`store_id` ) 
            WHERE su.`user_id` =$user_id
            and su.`deleted_at` is null
            and os.`deleted_at` is null
            and s.`deleted_at` is null");
        }
        

          
    }

    public static function org_store_wise_category_list($id)
    {
        return DB::table('assign_store_items as ast')
            ->join('item_categories as ic','ic.id','=','ast.item_cat_id')
            ->select('ic.id','ic.item_cat_name','ic.item_cat_code')
            ->where('ast.org_store_id',$id)
            ->whereNull('ast.deleted_at')
            ->whereNull('ic.deleted_at')
            ->get();

    }
    
    public static function common_dropdown_depend_one_column($table_name,$table_column_name,$table_column_id,$value,$text,$edit_id=null,$placeholder=null) //common dynamic dropdown in php.works as like as js common dropdown
    {
        $result=DB::table($table_name)
            ->where($table_column_name,$table_column_id)
            ->whereNull('deleted_at')
            ->get();
        $options='<option value="">'.Lang::get('messages.Select '.$placeholder).'</option>';    
        foreach ($result as $key => $row) {
            if($row->id==$edit_id)
            {
                $options.='<option value="'.$row->$value.'" selected="selected">'.$row->$text.'</option>';
            }else{
                $options.='<option value="'.$row->$value.'">'.$row->$text.'</option>';
            }
        }
        return $options;  
    }
    public static function common_dropdown($table_name,$value,$text,$edit_id=null,$placeholder=null)
    {
        $result=DB::table($table_name)
            ->whereNull('deleted_at')
            ->get();
        $options='<option value="">'.Lang::get('messages.Select '.$placeholder).'</option>';    
        foreach ($result as $key => $row) {
            if($row->id==$edit_id)
            {
                $options.='<option value="'.$row->$value.'" selected="selected">'.$row->$text.'</option>';
            }else{
                $options.='<option value="'.$row->$value.'">'.$row->$text.'</option>';
            }
        }
        return $options;  
    }
    public static function category_and_group_wise_item_list($item_cat_id,$item_group_id=null,$edit_id=null)
    {
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
        $options='<option value="">'.Lang::get('messages.Select Item').'</option>';    
        foreach ($result as $key => $row) {
            if($row->id==$edit_id)
            {
                $options.='<option value="'.$row->id.'" selected="selected">'.$row->item_name.'</option>';
            }else{
                $options.='<option value="'.$row->id.'">'.$row->item_name.'</option>';
            }
        }
        return $options;   
    }

    public static function org_wise_store_list($battalion_id,$wing_id,$branch_id,$sub_branch_id,$section_id,$sub_section_id,$edit_id=null)
    {
        $result=DB::table('organization_stores')
        ->join('stores', 'stores.id', '=', 'organization_stores.store_id')
        ->select('organization_stores.*','stores.store_name')
        ->where('battalion_id',$battalion_id ? $battalion_id : null)
        ->where('wing_id',$wing_id ? $wing_id : null)
        ->where('branch_id',$branch_id ? $branch_id : null)
        ->where('sub_branch_id',$sub_branch_id ? $sub_branch_id : null)
        ->where('section_id',$section_id ? $section_id : null)
        ->where('sub_section_id',$sub_section_id ? $sub_section_id : null)
        ->whereNull('organization_stores.deleted_at')
        ->whereNull('stores.deleted_at')
        ->get();

        $options='<option value="">'.Lang::get('messages.Select Store').'</option>';    
        foreach ($result as $key => $row) {
            if($row->id==$edit_id)
            {
                $options.='<option value="'.$row->id.'" selected="selected">'.$row->store_name.'</option>';
            }else{
                $options.='<option value="'.$row->id.'">'.$row->store_name.'</option>';
            }
        }
        return $options; 
        
    }

    public static function battalion_wise_employee_list($battalion_id,$wing_id,$branch_id,$sub_branch_id,$section_id,$sub_section_id,$edit_id=null)
    {
        if($battalion_id == 1 && !empty($wing_id)){
          
            $v_query="and pr.`battalion_id`=$battalion_id and pr.wing_id=$wing_id";
        }else{
           

            $v_query="and pr.`battalion_id`=$battalion_id";
        }

        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        where ei.deleted_at is null
        $v_query
        ");

        $options='<option value="">'.Lang::get('messages.Select employee').'</option>';    
        foreach ($result as $key => $row) {
            if($row->posting_rec_id==$edit_id)
            {
                $options.='<option value="'.$row->posting_rec_id.'" selected="selected">'.$row->rab_id.'</option>';
            }else{
                $options.='<option value="'.$row->posting_rec_id.'">'.$row->rab_id.'</option>';
            }
        }
        return $options; 
        
    }

    
    public static function filter_wise_employee_list($battalion_id,$wing_id,$branch_id,$sub_branch_id,$section_id,$sub_section_id,$edit_id=null)
    {
        
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


        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id 
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        where ei.deleted_at is null
        $v_query
        ");
        
        $options='<option value="">'.Lang::get('messages.Select employee').'</option>';    
        foreach ($result as $key => $row) {
            if($row->posting_rec_id==$edit_id)
            {
                $options.='<option value="'.$row->posting_rec_id.'" selected="selected">'.$row->rab_id.'</option>';
            }else{
                $options.='<option value="'.$row->posting_rec_id.'">'.$row->rab_id.'</option>';
            }
        }
        return $options; 
        
    }

    public static function filter_wise_employee_list_emp_id($battalion_id,$wing_id,$branch_id,$sub_branch_id,$section_id,$sub_section_id,$edit_id=null)
    {
        
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


        $result=DB::SELECT("SELECT pr.posting_rec_id,ei.rab_id,ei.emp_id 
        FROM `vw_present_employee_location` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        where ei.deleted_at is null
        $v_query
        ");
        
        $options='<option value="">'.Lang::get('messages.Select employee').'</option>';    
        foreach ($result as $key => $row) {
            if($row->emp_id==$edit_id)
            {
                $options.='<option value="'.$row->emp_id.'" selected="selected">'.$row->rab_id.'</option>';
            }else{
                $options.='<option value="'.$row->emp_id.'">'.$row->rab_id.'</option>';
            }
        }
        return $options; 
        
    }


    //.................Hrm start................
    public static function RAB_HQ_designation_wise_info($designation_name)
    {
        $v_result=DB::SELECT("SELECT ei.emp_name,r.rank_name 
        FROM 
        `posting_record` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        inner join ranks r on(r.id=ei.rank_id)
        inner join designations d on(d.id=ei.designation_id)
        WHERE pr.`battalion_id`=1 
        and pr.wing_id=1
        and pr.is_joined=1
        and d.designation_name='$designation_name'
        and ei.release_date is null
        and ei.deleted_at is null
        and pr.deleted_at is null
        and r.deleted_at is null
        and d.deleted_at is null");

        if(!empty($v_result))
        {
            return $v_result[0];
        }
        
    }
    //.................Hrm end................

    public static function category_wise_parts_list($parts_cat_id, $edit_id = null)
    {
        $result=DB::table('parts')
            ->select('id','parts_name')
            ->where('parts_cat_id', $parts_cat_id)
            ->whereNull('deleted_at')
            ->get();
        // return Response::json($result);
        $options='<option value="">'.Lang::get('messages.Select Parts').'</option>';    
        foreach ($result as $key => $row) {
            if($row->id == $edit_id)
            {
                $options.='<option value="'.$row->id.'" selected="selected">'.$row->parts_name.'</option>';
            }else{
                $options.='<option value="'.$row->id.'">'.$row->parts_name.'</option>';
            }
        }
        return $options;
    }

    public static function brand_wise_model_list($brand_id, $model_id = null)
    {
        $result=DB::table('vehicle_models')
            ->select('id','model_name')
            ->where('brand_id', $brand_id)
            ->whereNull('deleted_at')
            ->get();
        $options='<option value="">'.Lang::get('messages.Select Model').'</option>';    
        foreach ($result as $key => $row) {
            if($row->id == $model_id)
            {
                $options.='<option value="'.$row->id.'" selected="selected">'.$row->model_name.'</option>';
            }else{
                $options.='<option value="'.$row->id.'">'.$row->model_name.'</option>';
            }
        }
        return $options;
    }

    public static function RAB_HQ_designation_wise_emp_info($designation_id, $wing_id)
    {
        $v_result=DB::SELECT("SELECT ei.emp_name,r.rank_name 
        FROM 
        `posting_record` pr
        inner join employees_info ei on(ei.emp_id=pr.emp_id)
        inner join ranks r on(r.id=ei.rank_id)
        inner join designations d on(d.id=ei.designation_id)
        WHERE pr.`battalion_id`=1 
        and pr.wing_id= $wing_id
        and pr.is_joined=1
        and ei.designation_id='$designation_id'
        and ei.release_date is null
        and ei.deleted_at is null
        and pr.deleted_at is null
        and r.deleted_at is null
        and d.deleted_at is null");

        if(!empty($v_result))
        {
            return $v_result[0];
        }
        
    }

}
