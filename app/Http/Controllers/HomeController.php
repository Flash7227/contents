<?php

namespace App\Http\Controllers;
use App\Uploads;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;


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
        return view('user.home');
    }
    public function homecompIndex()
    {
        return view('user.home');
    }
    public function uploadData()
    {
        $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(3)->get();
        $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(3)->get();
        $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(3)->get();
        $niitlels = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(4)->get();
        return [$files, $videos, $posters, $niitlels];
    }
    /// niitlel
    public function niitlelcompIndex()
    {
        return view('files.niitlel');
    }
    public function niitlelFetch()
    {
        $getniitlel = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->paginate(9);
        return $getniitlel;
    }
    public function niitlelSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $created_at = $search['date'];

        $data = Uploads::query();
        $data->where('sharetype', "public")->where('type', '4');
    
        if($name){
            $data->where('name', $name);
            //$data->orWhere('name', 'like', '%' . $name . '%');
        };
        if($created_at){
            $data->whereDate('created_at', $created_at);
        };
        $data = $data->orderBy('created_at', 'DESC')->paginate(10);


        return [$data];

    }
    //poster
    public function postercompIndex()
    {
        return view('files.poster');
    }
    public function posterFetch()
    {
        $getposter = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->paginate(10);
        return $getposter;
    }
    public function posterSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $created_at = $search['date'];

        $data = Uploads::query();
        $data->where('sharetype', "public")->where('type', '3');
    
        if($name){
            $data->where('name', $name);
        };
        if($created_at){
            $data->whereDate('created_at', $created_at);
        };
        $data = $data->paginate(10);


        return [$data];

    }
    //video
    public function videocompIndex()
    {
        return view('files.video');
    }
    public function videoFetch()
    {
        $getvideo = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->paginate(6);
        return $getvideo;
    }
    public function videoSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $created_at = $search['date'];

        $data = Uploads::query();
        $data->where('sharetype', "public")->where('type', '2');
    
        if($name){
            $data->where('name', $name);
        };
        if($created_at){
            $data->whereDate('created_at', $created_at);
        };
        $data = $data->paginate(10);


        return [$data];

    }

    ///file
    public function filecompIndex()
    {
        return view('files.file');
    }
    public function fileFetch()
    {
        $getfile = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->paginate(10);
        return $getfile;
    }
    public function fileSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $created_at = $search['date'];

        $data = Uploads::query();
        $data->where('sharetype', "public")->where('type', '1');
    
        if($name){
            $data->where('name', $name);
        };
        if($created_at){
            $data->whereDate('created_at', $created_at);
        };
        $data = $data->paginate(10);


        return [$data];

    }
    
}


