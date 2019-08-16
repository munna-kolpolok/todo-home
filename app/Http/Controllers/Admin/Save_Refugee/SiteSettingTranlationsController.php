<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Http\Requests\SiteSettingRequest;
use Dwij\Laraadmin\Models\Menu;

use App\Models\Setting;
use App\Models\Language;
use App\Models\Sr_Setting;
use App\Models\Sr_Setting_Translation;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class SiteSettingTranlationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("setting_languages")) {
            $site_setting = Sr_Setting::first();
            $site_setting_trns = Sr_Setting_Translation::get();
            $languages = language::get();
            return view('admin.save_refugee.settings_translations.index', compact(['site_setting', 'site_setting_trns', 'languages']));
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
        if (Menu::hasAccess("Setting_Languages", "create")) {
            $existingLang = Sr_Setting_Translation::pluck('locale');
            $languages = language::whereNotIn('code', $existingLang)->get();

            return view('admin.save_refugee.settings_translations.create', compact(['languages']));
        } else {
            return View('error');
        }
    }

    public function createLang(Request $request)
    {
        dd($request->all());
        if (Menu::hasAccess("Setting_Languages", "create")) {
            $site_setting = Setting::first();
            return view('admin.save_refugee.settings_translations.create', compact('site_setting'));
        } else {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$data=$request->all();
        /*$data = $request->except('lang');
        $data['locale'] = $request->lang;*/
        // Sr_Setting_Translation::create($data);

        $sr_setting_trns = Sr_Setting_Translation::create($request->all());
        $languages = language::get();

        Session::flash('seccess_msg', Lang::get('messages.Saved successfully'));
        return view('admin.save_refugee.settings_translations.edit', compact(['sr_setting_trns', 'languages']));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('Setting_Languages', 'edit')) {
            $sr_setting_trns = Sr_Setting_Translation::find($id);
            $languages = language::get();

            return view('admin.save_refugee.settings_translations.edit', compact(['sr_setting_trns', 'languages']));
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update site settings
        $sr_setting_trns = Sr_Setting_Translation::find($id);
        $sr_setting_trns->update($request->all());


        //$sr_setting_trns= Sr_Setting_Translation::find($id);
        $languages = language::get();

        Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
        return view('admin.save_refugee.settings_translations.edit', compact(['sr_setting_trns', 'languages']));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess('Setting_Languages', 'delete')) {
            $data = Sr_Setting_Translation::find($id);
            $data->forcedelete();
            Session::flash('seccess_msg', Lang::get('messages.Delete successfully'));
            return redirect()->back();
        } else {
            return View('error');
        }
    }
}
