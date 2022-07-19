<?php

namespace App\Http\Controllers;
use App\Uploads;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        return view('welcome');
    }
    public function homecompIndex()
    {
        return view('user.home');
    }
    public function uploadData()
    {
        $uploadData = Uploads::where('allowed', '["public"]')->orderBy('created_at', 'DESC')->get();
        return $uploadData;
    }
}


