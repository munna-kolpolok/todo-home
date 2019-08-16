<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Collective\Html\FormFacade as Form;
use Session;

use URL;
use Cookie;
use Auth;
use DB;
use Lang;
use App\Models\Product;
use App\Models\Site_Setting;
use App\Models\Group;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index($group_id=null,$category_id=null,$sub_category_id=null)
    {
        if($group_id>0 && $category_id>0 && $sub_category_id>0)
        {
            $products=Product::where('group_id',$group_id)
            ->where('category_id',$category_id)
            ->where('sub_category_id',$sub_category_id)
            ->where('status',1)
            ->orderBy('product_date', 'DESC')
            ->paginate(6);
        }
        elseif($group_id>0 && $category_id>0)
        {
            $products=Product::where('group_id',$group_id)
            ->where('category_id',$category_id)
            ->where('status',1)
            ->orderBy('product_date', 'DESC')
            ->paginate(6);
        }
        elseif($group_id>0)
        {
            $products=Product::where('group_id',$group_id)
            ->where('status',1)
            ->orderBy('product_date', 'DESC')
            ->paginate(6);
        }
        else
        {
            $products=Product::where('status',1)
            ->orderBy('product_date', 'DESC')
            ->paginate(6);
        }
        
        $site_setting=Site_Setting::all()->first();

        //.............Pagination added end........

        
        $popularity_sorting=1;
        $price_sorting=1;
        return View('website.product.index', [
            'products' => $products,
            'site_setting' => $site_setting,
            'group_id' => $group_id,
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'popularity_sorting' => $popularity_sorting,
            'price_sorting' => $price_sorting,
        ]);
    }

    public function store(Request $request)
    {
        $group_id=$request->group_id;
        $category_id=$request->category_id;
        $sub_category_id=$request->sub_category_id;
        $popularity_sorting=$request->popularity_sorting;
        $price_sorting=$request->price_sorting;

        $price_bt_a=[];
        if($price_sorting==2)
        {
            $price_bt_a=[0,500];
        }
        elseif($price_sorting==3)
        {
            $price_bt_a=[500,2000];
        }
        elseif($price_sorting==4)
        {
            $price_bt_a=[2000,5000];
        }
        elseif($price_sorting==5)
        {
            $price_bt_a=[5000,1000000000];
        }

        if($group_id>0 && $category_id>0 && $sub_category_id>0)
        {
            if($popularity_sorting==2)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('sub_category_id',$sub_category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('popular', 'ASC')
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('sub_category_id',$sub_category_id)
                    ->where('status',1)
                    ->orderBy('popular', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==3)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('sub_category_id',$sub_category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('sub_category_id',$sub_category_id)
                    ->where('status',1)
                    ->orderBy('price', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==4)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('sub_category_id',$sub_category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'DESC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('sub_category_id',$sub_category_id)
                    ->where('status',1)
                    ->orderBy('price', 'DESC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
            }
            else
            {
                //........Default...............
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('sub_category_id',$sub_category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('sub_category_id',$sub_category_id)
                        ->where('status',1)
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
            }
        }
        elseif($group_id>0 && $category_id>0)
        {
            //........group and category start...........
            if($popularity_sorting==2)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('popular', 'ASC')
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('status',1)
                    ->orderBy('popular', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==3)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('status',1)
                    ->orderBy('price', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==4)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'DESC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('category_id',$category_id)
                    ->where('status',1)
                    ->orderBy('price', 'DESC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
            }
            else
            {
                //........Default...............
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('category_id',$category_id)
                        ->where('status',1)
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
            }
        }
        elseif($group_id>0)
        {
            //........group start...........
            if($popularity_sorting==2)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('popular', 'ASC')
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('status',1)
                    ->orderBy('popular', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==3)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('status',1)
                    ->orderBy('price', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==4)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'DESC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                    ->where('status',1)
                    ->orderBy('price', 'DESC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
            }
            else
            {
                //........Default...............
                if($price_sorting>1)
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('group_id',$group_id)
                        ->where('status',1)
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
            }
        }
        else
        {
            //........all products start...........
            if($popularity_sorting==2)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('popular', 'ASC')
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('status',1)
                    ->orderBy('popular', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==3)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('status',1)
                    ->orderBy('price', 'ASC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
                
            }
            elseif($popularity_sorting==4)
            {
                if($price_sorting>1)
                {
                    $products=Product::where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'DESC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('status',1)
                    ->orderBy('price', 'DESC')
                    ->orderBy('product_date', 'DESC')
                    ->paginate(6);
                }
            }
            else
            {
                //........Default...............
                if($price_sorting>1)
                {
                    $products=Product::where('status',1)
                        ->whereBetween('price', $price_bt_a)
                        ->orderBy('price', 'ASC')
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
                else
                {
                    $products=Product::where('status',1)
                        ->orderBy('product_date', 'DESC')
                        ->paginate(6);
                }
            }
        }
        
        $site_setting=Site_Setting::all()->first();
        return View('website.product.index', [
            'products' => $products,
            'site_setting' => $site_setting,
            'group_id' => $group_id,
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'popularity_sorting' => $popularity_sorting,
            'price_sorting' => $price_sorting,
        ]);
    }
    public function show($id)
    {
        $product=Product::find($id);
        //$site_setting=Site_Setting::all()->first();
        return View('website.product.product_details', [
            'product' => $product,
        ]);
    }

    public function cart(Request $request)
    {
        //$products = Product::whereIn('id', $request->product_id)->get();
        $site_setting=Site_Setting::all()->first();
        $product_ids=$request->product_id;
        $quantity=$request->quantity;
        $color_id=$request->color_id;
        $size_id=$request->size_id;
        $delivery_charge=$site_setting->delivery_charge;
        
        return View('website.product.cart', [
            'product_ids' => $product_ids,
            'quantity' => $quantity,
            'color_id' => $color_id,
            'size_id'=>$size_id,
            'site_setting' => $site_setting,
            'delivery_charge'=>$delivery_charge,
            
        ]);
    }

}