<?php

namespace App\Http\Controllers;
use App\Uploads;
use Illuminate\Http\Request;

class NewHomeController extends Controller
{
    public function index()
    {
        return view('user.home');
    }
    public function fetch()
    {
        $blog = Uploads::where('sharetype', "public")->where('type', '4')->orderBy('created_at', 'DESC')->limit(6)->get();
        $files = Uploads::where('sharetype', "public")->where('type', '1')->orderBy('created_at', 'DESC')->limit(8)->get();
        $videos = Uploads::where('sharetype', "public")->where('type', '2')->orderBy('created_at', 'DESC')->limit(4)->get();
        $posters = Uploads::where('sharetype', "public")->where('type', '3')->orderBy('created_at', 'DESC')->limit(4)->get();
        return [$blog, $files, $videos, $posters];
    }
    public function blogFetch($id)
    {
        $blog = Uploads::find($id);
        return view('files.blog2', ['blog'=>$blog]);
    }
}

