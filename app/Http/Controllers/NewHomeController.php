<?php

namespace App\Http\Controllers;
use App\Uploads;
use App\Counter;
use Illuminate\Support\Facades\Auth;
use App\Tags;
use Illuminate\Http\Request;

class NewHomeController extends Controller
{
    public function index()
    {
        $tags = Tags::all();
        return view('user.home', ['tags'=>$tags]);
    }
    public function fetch()
    {
        if(Auth::check()){
            if(Auth()->user()->email_verified_at){
                $blog = Uploads::whereIn('sharetype', ["public", "all"])->where('type', '4')->orderBy('created_at', 'DESC')->limit(4)->get();
                $files = Uploads::whereIn('sharetype', ["public", "all"])->where('type', '1')->orderBy('created_at', 'DESC')->limit(4)->get();
                $videos = Uploads::whereIn('sharetype',["public", "all"])->where('type', '2')->orderBy('created_at', 'DESC')->limit(4)->get();
                $posters = Uploads::whereIn('sharetype', ["public", "all"])->where('type', '3')->orderBy('created_at', 'DESC')->limit(4)->get();
            }else{
                $blog = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(4)->get();
                $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(4)->get();
                $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(4)->get();
                $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(4)->get();
            }
    
        }else{
            $blog = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(4)->get();
            $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(4)->get();
            $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(4)->get();
            $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(4)->get();
        }

        return [$blog, $files, $videos, $posters];
    }
    public function blogFetch($id)
    {
        $blog = Uploads::find($id);
        $counter = Counter::where('upload_id', $id)->first();
        if($counter){
            $counter->view = $counter->view + 1;
        }else{
            $counter = new Counter;
            $counter->upload_id = $id;
            $counter->view = 1;
        }
        $counter->save();
        return view('files.blog2', ['blog'=>$blog]);
    }
    public function addCountView($id)
    {
        $counter = Counter::where('upload_id', $id)->first();
        if($counter){
            $counter->view = $counter->view + 1;
        }else{
            $counter = new Counter;
            $counter->upload_id = $id;
            $counter->view = 1;
        }
        $counter->save();
        return "count added!";
    }
    public function addCountDownload($id)
    {
        $counter = Counter::where('upload_id', $id)->first();
        if($counter){
            $counter->download = $counter->download + 1;
        }else{
            $counter = new Counter;
            $counter->upload_id = $id;
            $counter->download = 1;
        }
        $counter->save();
        return "count added!";
    }
}

