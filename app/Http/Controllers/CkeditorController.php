<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        $path_url = '/storage/ckeditor';

        if ($request->hasFile('upload')) {
           $originName = $request->file('upload')->getClientOriginalName();
           $filename = pathinfo($originName,PATHINFO_FILENAME);
           $time = Auth()->user()->id.'_'.time();
           // $filename = uniqid().Auth()->user()->id;
           $filename = $filename.'_'.$time;
           $extension = $request->file('upload')->getClientOriginalExtension();
           $fileName = $filename.$time.$extension;
           $request->file('upload')->move(public_path($path_url), $fileName);
           $url = asset($path_url . '/' . $fileName);
        }
        return response()->json(['url' => $url]);
    }

    public function upload2(Request $request)
    {
        $path_url = '/storage/vue2editor';

        if ($request->hasFile('upload')) {
           $originName = $request->file('upload')->getClientOriginalName();
           $filename = pathinfo($originName,PATHINFO_FILENAME);
           $time = Auth()->user()->id.'_'.time();
           // $filename = uniqid().Auth()->user()->id;
           $filename = $filename.'_'.$time;
           $extension = $request->file('upload')->getClientOriginalExtension();
           $fileName = $filename.$time.'.'.$extension;
           $request->file('upload')->move(public_path($path_url), $fileName);
           $url = asset($path_url . '/' . $fileName);
        }
        return response()->json(['url' => $url]);
    }
}
