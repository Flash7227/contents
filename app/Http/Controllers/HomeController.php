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
        $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(5)->get();
        $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(3)->get();
        $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(3)->get();
        $niitlels = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(5)->get();
        return [$files, $videos, $posters, $niitlels];
    }
    /// niitlel
    public function niitlelcompIndex()
    {
       // $uploadData = Uploads::where('sharetype', "public")->orderBy('created_at', 'DESC')->get();
        return view('files.niitlel');
    }
    public function niitlelFetch()
    {
        $getniitlel = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->get();
        return $getniitlel;
    }
    //poster
    public function postercompIndex()
    {
        return view('files.poster');
    }
    public function posterFetch()
    {
        $getposter = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->get();
        return $getposter;
    }
    //video
    public function videocompIndex()
    {
        return view('files.video');
    }
    public function videoFetch()
    {
        $getvideo = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->get();
        return $getvideo;
    }

    ///file
    public function filecompIndex()
    {
        return view('files.file');
    }
    public function fileFetch()
    {
        $getfile = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->get();
        return $getfile;
    }
    
}


