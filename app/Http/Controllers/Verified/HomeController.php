<?php

namespace App\Http\Controllers\Verified;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('verified.home');
    }
}
