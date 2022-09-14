<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Uploads;
use App\Tags;
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
        $tags = Tags::all();
        return view('user.home', ['tags'=>$tags]);
    }
    public function homecompIndex()
    {
        $tags = Tags::all();
        return view('user.home', ['tags'=>$tags]);
    }
    public function uploadData()
    {
        $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(6)->get();
        $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(3)->get();
        $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(6)->get();
        $niitlels = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(6)->get();
        return [$files, $videos, $posters, $niitlels];
    }
    /// niitlel
    public function blogcompIndex()
    {
        return view('files.blog');
    }
    public function blogFetch()
    {
        if (Auth::check()){
            $getniitlel = Uploads::whereIn('sharetype', ['public', 'all'])->where('type', '4')->orderBy('created_at', 'DESC')->paginate(9);
 
        }else{
            $getniitlel = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->paginate(9);
        }
        $tags=Tags::get();
        return [$getniitlel, $tags];
    }
    public function blogSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $tags = $search['tag'];
        $dates = $search['date'];
       
       

        $data = Uploads::query();
        if (Auth::check()){
            $data->whereIn('sharetype', ['public', 'all'])->where('type', '4');
        }else{
            $data->where('sharetype', "public")->where('type', '4');
        }

        if($name){
            $data->where('name', 'like', '%'.$name.'%');
            //$data->orWhere('name', 'like', '%' . $name . '%');
        };
        if($tags){
            foreach($tags as $tag){
                $data->whereJsonContains('tags', $tag);
            }
        };
        if($dates){
            $data->whereBetween('created_at', [$dates[0],$dates[1]]);
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
        if (Auth::check()){
            $getposter = Uploads::whereIn('sharetype', ['public', 'all'])->where('type', '3')->orderBy('created_at', 'DESC')->paginate(10);
        }else{
            $getposter = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->paginate(10);
        }
        
        $tags=Tags::get();
        return [$getposter, $tags];
    }
    public function posterSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $tags = $search['tag'];
        $dates = $search['date'];
        //return $dates;

        $data = Uploads::query();
        if (Auth::check()){
            $data->whereIn('sharetype', ['public', 'all'])->where('type', '3');
        }else{
            $data->where('sharetype', "public")->where('type', '3'); 
        }

        if($name){
            $data->where('name', 'like', '%'.$name.'%');
        };
        if($tags){
            foreach($tags as $tag){
                $data->whereJsonContains('tags', $tag);
            }
        };
        if($dates){
            $data->whereBetween('created_at', [$dates[0],$dates[1]]);
        };
        $data = $data->orderBy('created_at', 'DESC')->paginate(10);
        return [$data];

    }
    //video
    public function videocompIndex()
    {
        return view('files.video');
    }
    public function videoFetch()
    {
        if (Auth::check()){
            $getvideo = Uploads::whereIn('sharetype', ['public','all'])->where('type', '2')->orderBy('created_at', 'DESC')->paginate(9);
        }else{
            $getvideo = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->paginate(9);
        }
        $tags=Tags::get();
        return [$getvideo, $tags];
    }
    public function videoSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $tags = $search['tag'];
        $dates = $search['date'];
        //return $tag;

        $data = Uploads::query();
        if (Auth::check()){
            $data->whereIn('sharetype', ['public', 'all'])->where('type', '2');

        }else{
            $data->where('sharetype', "public")->where('type', '2');
        }
    
        if($name){
            $data->where('name', 'like', '%'.$name.'%');
        };
        if($tags){
            
            foreach($tags as $tag){
                $data->whereJsonContains('tags', $tag);

            }
        };
        if($dates){
            $data->whereBetween('created_at', [$dates[0],$dates[1]]);
        };
        $data = $data->orderBy('created_at', 'DESC')->paginate(10);
        return [$data];
    }

    ///file
    public function filecompIndex()
    {
        return view('files.file');
    }
    public function fileFetch()
    {
        if (Auth::check()){
            $getfile = Uploads::whereIn('sharetype', ['public', 'all'])->where('type', '1')->orderBy('created_at', 'DESC')->paginate(10);
        }else{
            $getfile = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->paginate(10);
        }
        $tags=Tags::get();
        return [$getfile, $tags];
    }
    public function fileSearch(Request $req){
        $search = $req->input('search');
        $name = $search['name'];
        $tags = $search['tag'];
        $dates = $search['date'];

        $data = Uploads::query();
        if (Auth::check()){
            $data->whereIn('sharetype', ['public', 'all'])->where('type', '1');
        }else{
            $data->where('sharetype', "public")->where('type', '1');
        }
       
        if($name){
            $data->where('name', 'like', '%'.$name.'%');
        };
        if($tags){
            foreach($tags as $tag){
                $data->whereJsonContains('tags', $tag);
            }
        };
        if($dates){
            $data->whereBetween('created_at', [$dates[0],$dates[1]]);
        };
        $data = $data->orderBy('created_at', 'DESC')->paginate(10);

        return [$data];

    }

   
    
}


