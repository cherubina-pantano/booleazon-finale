<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    //Home
    public function home() {
        return view('home');
    }
    //About
    public function about() {
        return view('about');
    }
}
