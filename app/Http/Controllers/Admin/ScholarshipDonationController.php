<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scholarship_Donation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScholarshipDonationController extends Controller
{
    public function index()
    {
        if (Menu::hasAccess('scholarship_donations')) {
            $donations = Scholarship_Donation::with('scholarship', 'currency', 'user')->orderBy('id', 'desc')->get();
            return view('admin.scholarship_donations.index', compact('donations'));
        } else {
            return View('error');
        }
    }
}
