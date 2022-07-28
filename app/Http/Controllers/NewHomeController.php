<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewHomeController extends Controller
{
    public function Index()
    {
        return view('user.home');
    }
}
