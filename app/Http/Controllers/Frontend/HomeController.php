<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.pages.auth.login');
        // return view('frontend.pages.home.index');
    }

    public function login()
    {
        return view('frontend.pages.auth.login');
    }
}
