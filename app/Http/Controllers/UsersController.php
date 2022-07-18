<?php

namespace App\Http\Controllers;
use App\Uploads;
use Storage;
use League\Flysystem\Filesystem;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function uploadIndex()
    {
        $emails = User::select('email')->get()->pluck('email');
        return view('user.upload', ['emails'=>$emails]);
    }
    public function uploadPost(Request $req)
    {
        // return $req->all();
        if(!$req->hasFile('file')){
            return response()->json([
                'error' => 'No File Uploaded'
            ]);
        }

        $file = $req->file('file');
        
        if(!$file->isValid()){
            return response()->json([
                'error' => 'File is not valid!'
            ]);
        }
        
        $filenamewithExt= $file->getClientOriginalName();
        //get just filename
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        $time = Auth()->user()->id.'_'.time();
        // $filename = uniqid().Auth()->user()->id;
        $filename = $filename.'_'.$time;
        // return $filename;
        //get jsut extension
        $extension = $file->guessClientExtension();
        //file name to store
        $fileNameToStore = $filename.'.'.$extension;
        // $clientFileSize=$req->file('file')->getSize();
        //Upload Image
        // $path = $file->storeAs('public/uploads/', $fileNameToStore);
        $disk = Storage::disk('local');
        $disk->putFileAs('/public/uploads', $file, $fileNameToStore );
    
        // $comparesize=$clientFileSize-$ftpFileSize;
        // return $file;
        if($disk){
            $upload = new Uploads;
            $upload->type = $req->input('type');;
            $upload->url = $fileNameToStore;
            $upload->name = $req->input('name');
            $tags = explode(",", $req->input('dynamicTags'));
            $allowed = explode(",", $req->input('allowed'));
            $upload->tags = json_encode($tags);
            $upload->allowed = json_encode($allowed);
            $upload->desc = $req->input('desc');
            $upload->user_id = Auth()->user()->id;
            $upload->size = $req->input('size');
            $upload->save();
            return "success";
        }else{
            return "error";
        }
    }
    public function uploadFetch(Request $req)
    {
        $lists = Uploads::where('user_id', Auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return $lists;
    }
    public function sharedIndex()
    {
        return view('user.shared');
    }
}
