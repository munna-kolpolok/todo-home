<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CampaignImageRequest;
use App\Http\Requests\CampaignImageUpdateRequest;
use App\Models\Campaign;
use App\Models\Campaign_Images;
use Illuminate\Http\Request;

use Dwij\Laraadmin\Models\Menu;
use Image;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CampaignImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('Camapaign_Images')) {
            $campaigns = Campaign::where('website_id',1)->orderBy('id')->get();
            $images = Campaign_Images::with('campaign')->orderBy('id', 'desc')->get();
            return View('admin.campaign_images.index',['images'=>$images, 'campaigns' => $campaigns,'firstCampaign' => $campaigns->first()]);
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
        if (Menu::hasAccess('Camapaign_Images','create')) {
            $campaigns = Campaign::where('website_id',1)->orderBy('id')->get();
            return View('admin.campaign_images.create',['campaigns'=>$campaigns]);
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
    public function store(CampaignImageRequest $request)
    {
        if (Menu::hasAccess('Camapaign_Images','create')) {
            $data = [];
            $campaignImages = Campaign_Images::orderBy('id', 'desc')->get();
            $serial_no = $campaignImages->max('serial_no') + 1;
            $campaign_id = $request->campaign_id;

            foreach($request->images as $index => $image) {
                $incressSerialNo = $serial_no++;
                $path = public_path() . '/uploads/campaigns/'.$campaign_id.'/campaign_images/';
                $database_image_folder_path='/uploads/campaigns/'.$campaign_id.'/campaign_images/';

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $campaign_image = $image;
                    $campaign_big_image = 'bidyanondo-'.$incressSerialNo.'-big.'.$campaign_image->getClientOriginalExtension();
                    $campaign_big_image_path= $path . $campaign_big_image;

                    $image_name = 'bidyanondo-'.$incressSerialNo.'.'.$campaign_image->getClientOriginalExtension();
                    $campaign_image_path=$path . $image_name;

                    Image::make($campaign_image->getRealPath())->resize(800, 550)->save($campaign_big_image_path);
                    Image::make($campaign_image->getRealPath())->resize(360, 250)->save($campaign_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$campaign_big_image;
                    $data[$index]['big_image'] =$database_image_path_big;
                    $data[$index]['image'] =$database_image_path;
                    $data[$index]['serial_no'] = $incressSerialNo;
                    $data[$index]['campaign_id'] = $campaign_id;
                }
            }
            Campaign_Images::insert($data);
            Session::flash('message',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.camapaign_images.index');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign_Images $camapaign_images)
    {
        if (Menu::hasAccess('Camapaign_Images','edit')) {
            $campaigns = Campaign::where('website_id',1)->orderBy('id')->get();
            return view('admin.campaign_images.edit', compact('campaigns','camapaign_images'));
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
    public function update(CampaignImageUpdateRequest $request, Campaign_Images $camapaign_images)
    {
        if (Menu::hasAccess('Camapaign_Images','edit')) {
            $data = $request->except('image');
            $campaign_id = $request->campaign_id;
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/campaigns/'.$campaign_id.'/campaign_images/';
                $database_image_folder_path='/uploads/campaigns/'.$campaign_id.'/campaign_images/';
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $existing_image = public_path().'/'.$camapaign_images->image;
                    $existing_big_image = public_path().'/'.$camapaign_images->big_image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                        @unlink($existing_big_image);
                    }
                    $campaign_image = $request->image;
                    $campaign_big_image = '/'.'bidyanondo-'.$camapaign_images->id.'-'.time().'-big.'.$campaign_image->getClientOriginalExtension();
                    $campaign_big_image_path=$path . $campaign_big_image;

                    $image_name = '/'.'bidyanondo-'.$camapaign_images->id.'-'.time().'.'.$campaign_image->getClientOriginalExtension();
                    $campaign_image_path=$path . $image_name;

                    Image::make($campaign_image->getRealPath())->resize(800, 550)->save($campaign_big_image_path);
                    Image::make($campaign_image->getRealPath())->resize(360, 250)->save($campaign_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$campaign_big_image;
                    $data['big_image'] = $database_image_path_big;
                    $data['image'] = $database_image_path;
                }

            }
            $camapaign_images->update($data);
            Session::flash('message',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.camapaign_images.index');

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
    public function destroy(Campaign_Images $camapaign_images)
    {
        if (Menu::hasAccess("Camapaign_Images", "delete")) {
            //delete existing image folder
            $image_path = public_path() . '/' . $camapaign_images->image;
            $image_big_path = public_path() . '/' . $camapaign_images->big_image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
                @unlink($image_big_path);
            }
            $camapaign_images->delete();
            Session::flash('message',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.camapaign_images.index');
        } else {
            return View('error');
        }
    }

    public function order($id)
    {
        if (Menu::hasAccess('Camapaign_Images')) {
            $campaignImages = Campaign_Images::where('campaign_id',$id)->with('campaign')->orderBy('serial_no','asc')->get();
            return View('admin.campaign_images.order',['campaignImages'=>$campaignImages, 'campaignId' => $id]);
        } else {
            return View('error');
        }
    }

    public function orderUpdate(Request $request)
    {
        $id = $request->project_id;
        $campaignImages = Campaign_Images::where('campaign_id',$id)->orderBy('serial_no','asc')->get();
        foreach ($campaignImages as $image) {
            $image->timestamps = false;
            $id = $image->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $image->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
