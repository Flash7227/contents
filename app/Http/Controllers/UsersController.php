<?php

namespace App\Http\Controllers;
use App\Uploads;
use Storage;
use League\Flysystem\Filesystem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class UsersController extends Controller
{
    public function uploadIndex()
    {
        $emails = User::select('email')->get()->pluck('email');
        return view('user.upload', ['emails'=>$emails]);
    }
    public function uploadPost(Request $req)
    {
        if($req->input('form')){
            //post oruulah uyed l form bn
            $form = $req->input('form');
            $name = $form['name'];
            $type = $form['type'];
            $desc = $form['desc'];
            $temp_tags = $form['dynamicTags'];
            $temp_allowed = $form['allowed'];
            $sharetype = $form['sharetype'];
            $size = 0;
        }else{
            $name = $req->input('name');
            $type = $req->input('type');
            $desc = $req->input('desc');
            $temp_tags = $req->input('dynamicTags');
            $temp_allowed = $req->input('allowed');
            $size = $req->input('size');
            $sharetype = $req->input('sharetype');

            if(!$req->hasFile('file')){
                return response()->json([
                    'error' => 'No File Uploaded'
                ]);
            }
        }
  
        if($req->hasFile('file')){
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
            $filename = $filename.'_'.$time;
            //get jsut extension
            $extension = $file->guessClientExtension();
            //file name to store
            $fileNameToStore = $filename.'.'.$extension;
            //Upload Image
            // $path = $file->storeAs('public/uploads/', $fileNameToStore);
            $disk = Storage::disk('local');
            $disk->putFileAs('/public/uploads', $file, $fileNameToStore);
        }else{
            $disk = true;
            $fileNameToStore = 'noimage123.png';
        }
        if($disk){
            $upload = new Uploads;
            $upload->type = $type;
            $upload->url = $fileNameToStore;
            $upload->name = $name;
            $upload->sharetype = $sharetype;
            $tags = [];
            if($temp_tags){
                if(!is_array($temp_tags)){
                    $tags = explode(",", $temp_tags);
                }else{
                    $tags = $temp_tags;
                }
            };
            $allowed = [];
            if($temp_allowed){
                if (!is_array($temp_allowed)) {
                    $allowed = explode(",", $temp_allowed);
                }else{
                    $allowed = $temp_allowed;
                }
            }
            $upload->tags = json_encode($tags);
            $upload->allowed = json_encode($allowed);
            $upload->desc = $desc;
            $upload->user_id = Auth()->user()->id;
            $upload->size = $size;
            $upload->save();
            return "success";
        }else{
            return "error";
        }
    }
    public function uploadModify(Request $req)
    {
        $form = $req->input('form');
        $type = $req->input('type');
        $upload = Uploads::find($form['id']);
        if($type == 'del'){
            if($upload->url != 'noimage123.png'){
                if (Storage::exists('/public/uploads/'.$upload->url)) {
                    Storage::delete('/public/uploads/'.$upload->url);
                }
            }
            $upload->delete();
        }else{
            $upload->name = $form['name'];
            $upload->desc = $form['desc'];
            $upload->sharetype = $form['sharetype'];
            $tags = [];
            if($form['dynamicTags']){
                // $tags = explode(",", $form['dynamicTags']);
                $tags = $form['dynamicTags'];
            };
            $allowed = [];
            if($form['allowed']){
                // $allowed = explode(",", $form['allowed']);
                $allowed = $form['allowed'];
            }
            $upload->tags = json_encode($tags);
            $upload->allowed = json_encode($allowed);
            $upload->save();
        }
        return "success";
    }
    public function uploadModifyCover(Request $req)
    {
        if($req->hasFile('file')){
            $file = $req->file('file');
            if(!$file->isValid()){
                return response()->json([
                    'error' => 'File is not valid!'
                ]);
            }
            $id = $req->input('id');
            $size = $req->input('size');
            $sharetype = $req->input('sharetype');
            $filenamewithExt= $file->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            $time = Auth()->user()->id.'_'.time();
            $filename = $filename.'_'.$time;
            //get jsut extension
            $extension = $file->guessClientExtension();
            //file name to store
            $fileNameToStore = $filename.'.'.$extension;
            //Upload Image
            // $path = $file->storeAs('public/uploads/', $fileNameToStore);
            $disk = Storage::disk('local');
            $disk->putFileAs('/public/uploads', $file, $fileNameToStore);
            if($disk){
                $upload = Uploads::find($id);
                if($upload->url != 'noimage123.png'){
                    if (Storage::exists('/public/uploads/'.$upload->url)) {
                        Storage::delete('/public/uploads/'.$upload->url);
                    }
                }
                $upload->url = $fileNameToStore;
                $upload->size = $size;
                $upload->save();
                return "success";
            }else{
                return response()->json([
                    'error' => 'Unable to save!'
                ]);
            }
        }else{
            return response()->json([
                'error' => 'No File Uploaded'
            ]);
        }
        
        
    }
    public function uploadFetch(Request $req)
    {
        $lists = Uploads::where('user_id', Auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(15);
        $dataused = Uploads::where('user_id', Auth()->user()->id)->sum('size');
        return [$lists, $dataused];
    }
    public function sharedIndex()
    {
        return view('user.shared');
    }

    public function sharedFetch(Request $request){
        $email = Auth()->user()->email;
        $data = Uploads::
        // where('allowed', Auth()->user()->email)
        whereJsonContains('allowed', $email)
        // ->orWhereJsonContains('allowed','public')
        ->paginate(12);
        
        $tags = Uploads::whereJsonContains('allowed', $email)
        ->select('tags')
        ->pluck('tags')
        // ->toArray()
        // ->merge('tags')
        ;
        return [$data];
    }

    public function fetchByTag(Request $request){
        $tag = $request['selectedTag'];
        $email = Auth()->user()->email;
        $data = Uploads::
        // where('allowed', Auth()->user()->email)
        whereJsonContains('allowed', $email)
        ->whereJsonContains('tags',$tag)
        ->paginate(100);
        // return [$email, $tag];
        return $data;
    }

    public function fetchSearch(Request $req){
        $email = Auth()->user()->email;
        $search = $req->input('search');
        $name = $search['name'];
        $type = $search['type'];
        $tag = $search['tag'];
        $created_at = $search['date'];

        $data = Uploads::query();
        $data->whereJsonContains('allowed', $email);
        if($name){
            $data->where('name', $name);
        };
        if($type){
            $data->where('type', $type);
        };
        if($tag){
            $data->whereJsonContains('tags', [$tag]);
        };
        if($created_at){
            $data->whereDate('created_at', $created_at);
        };

        $data=$data->paginate(10);
        return [$data];
    }

    //user profile & upload profile photo

    public function profileIndex(){
        return view('admin.profile');
    }

    public function profileUpload(Request $req){
        $data =  Auth::user();

        return [$data];
    }

    public function avatarUpload(Request $req){

        if(!$req->hasFile('file'))
        return response()->json([
            'error' => 'No File Uploaded'
        ]);
        
        $file = $req->file('file');
        if(!$file->isValid()){
            return response()->json([
                'error' => 'File is not valid!'
            ]);
        } else {
            $filenamewithExt= $file->getClientOriginalName();
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            $extension = $file->guessClientExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $file->storeAs('public/uploads',$fileNameToStore); 
            // return $path;
            };

            $user = Auth::user();

            if ($user->avatar) {
                Storage::delete('public/uploads' . '/' . $user->avatar);
                $user->avatar = null;
                $user->save();
            }

            $user->avatar = $fileNameToStore;
            $user->save();
            return $user;

    }
}
