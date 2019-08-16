<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Models\Website;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Campaigns")) {
            $campaigns = Campaign::where('website_id', '1')->orderby('id', 'desc')->get();
            return View('admin.campaigns.index', [
                'campaigns' => $campaigns,
            ]);
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Menu::hasAccess("Campaigns", "create")) {
            $websites = Website::all();
            return View('admin.campaigns.create', [
                'websites' => $websites,
            ]);
        } else {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        if (Menu::hasAccess("Campaigns", "create")) {
            $campaigns = Campaign::where('website_id',1)->orderBy('id', 'desc')->get();
            $serial_no = $campaigns->max('serial_no') + 1;
            $data = $request->except('date','cover_image');
            $data['date'] = CommonHelper::databseDateTimeFormatWithCurrentTime($request->date);
            $data['serial_no'] = $serial_no;
            $campaign = Campaign::create($data);
            $campaign_id = $campaign->id;
            /*Image upload*/
            if ($request->hasFile('cover_image')) {
                $path = public_path() . '/uploads/campaigns/'.$campaign_id;
                $database_image_folder_path = '/uploads/campaigns/'.$campaign_id;
                //dd($request->cover_image);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $image = $request->file('cover_image');
                    $image_name = '/bidyanondo'.'-'.time().'-cover'.'.'.$image->getClientOriginalExtension();
                    $path_image=$path . $image_name;
                    Image::make($image->getRealPath())->resize(480, 538)->save($path_image);
                    $database_image_path = $database_image_folder_path . $image_name;
                    $campaign->cover_image = $database_image_path;
                    $campaign->save();
                }
            }
            Session::flash('message', Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');

        } else {
            return View('error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaigns)
    {
        if (Menu::hasAccess("Campaigns", "view")) {
            return View('admin.campaigns.show', compact('campaigns'));
        } else {
            return View('error');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaigns)
    {
        if (Menu::hasAccess('campaigns', 'edit')) {
            $websites = Website::all();
            return view('admin.campaigns.edit', compact('campaigns', 'websites'));
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, Campaign $campaigns)
    {
        if (Menu::hasAccess("Campaigns", "edit")) {
            $data = $request->except('date','cover_image');
            $data['date'] = CommonHelper::databseDateTimeFormatWithCurrentTime($request->date);
            //$campaign = Campaign::create($data);
            $campaign_id = $campaigns->id;
            /*Image upload*/
            if ($request->hasFile('cover_image')) {
                $path = public_path() . '/uploads/campaigns/'.$campaign_id;
                $database_image_folder_path = '/uploads/campaigns/'.$campaign_id;
                //dd($request->cover_image);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $existing_image = public_path() . '/' . $campaigns->cover_image;
                    if (file_exists($existing_image)) {
                        @unlink($existing_image);
                    }
                    $image = $request->file('cover_image');
                    $image_name = '/bidyanondo'.'-'.time().'-cover'.'.'.$image->getClientOriginalExtension();
                    $path_image=$path . $image_name;
                    Image::make($image->getRealPath())->resize(480, 538)->save($path_image);
                    $database_image_path = $database_image_folder_path . $image_name;
                    $data['cover_image'] = $database_image_path;
                }
            }
            $campaigns->update($data);
            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');

        } else {
            return View('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaigns)
    {
        if (Menu::hasAccess("Campaigns", "delete")) {
            //delete existing image folder
            $path = public_path() . '/uploads/campaigns/'.$campaigns->id;
            if (File::exists($path)){
                File::deleteDirectory($path);
            }
            $campaigns->images()->delete();
            $campaigns->delete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');
        } else {
            return View('error');
        }
    }

    public function order()
    {
        if (Menu::hasAccess('Campaigns')) {
            $campaigns = Campaign::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
            return View('admin.campaigns.order', ['campaigns' => $campaigns]);
        } else {
            return View('error');
        }
    }

    public function orderUpdate(Request $request)
    {
        $campaigns = Campaign::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
        foreach ($campaigns as $campaign) {
            $campaign->timestamps = false;
            $id = $campaign->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $campaign->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
