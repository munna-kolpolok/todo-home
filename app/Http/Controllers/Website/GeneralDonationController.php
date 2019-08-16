<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GeneralDonationController extends Controller
{
    public function donate()
    {
        return view('website.about.donate');
    }
}
