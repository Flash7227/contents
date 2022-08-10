<?php

namespace App\Http\Controllers;

use App\Uploads;
use App\Counter;
use App\User;
use App\Tags;
use App\Logmaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{

    public function userIndex(){
        if(Auth()->user()->role === 1){
            return view('admin.admin');
        }else {
            return redirect()->back();
        }
        
    }

    public function userFetch(){
        $users = User::addSelect(['uploaded' => Uploads::selectRaw('sum(size) as total')
        ->whereColumn('user_id', 'users.id')
        ->groupBy('user_id')

    ])->paginate(10);
        return $users;
    }


    public function userEdit(Request $request){

        

        if($request->input('delete')){
            $user = User::find($request->input('id'));
            if($user->delete()){
                return 'success';
            };
        }else{
            
            // $request->validate([
            //     'email' => 'required|unique:email'.$userr->id
            // ]);
            
            $form = $request->input('form');
            if(isset($form['id'])){
                $user = User::find($form['id']);
            }else{
                $user = new User;

                $userr = Auth()->user();

                $validator = Validator::make($request->all(), 
                [
                    'email' => ['required','string','email' , 'unique:users'],
                    'password' => ['required','string','min:4']
                ]
            );
            }
                if($form['password']){
                    $user->fill(
                    [
                        'name' => $request['form']['name'],
                        'email' => $request['form']['email'],
                        'permissions' => $request['form']['permissions'],
                        'role' => $request['form']['role'],
                        'storage_limit' => $request['form']['storage_limit'],
                        'password' => Hash::make($request['form']['password']),
                    ]);
                }else {
                    $user->fill(
                        [
                            'name' => $request['form']['name'],
                            'email' => $request['form']['email'],
                            'permissions' => $request['form']['permissions'],
                            'role' => $request['form']['role'],
                            'storage_limit' => $request['form']['storage_limit'],
                        ]);
                }

            if($user->save()){
                return 'success';
            }
        }
        return 'error';
    }

    

    public function uploadIndex()
    {
        $emails = User::select('email')->get()->pluck('email');
        $tags = Tags::all();
        return view('admin.uploads', ['emails'=>$emails, 'tags'=>$tags]);
    }
    public function uploadFetch(Request $req)
    {
        $upload = Uploads::query();
        if($req->form['email']){
            $user = User::where('email', $req->form['email'])->first();
            if($user){
                $upload->where('user_id', $user->id);
            }else{
                $upload->where('user_id', 0);
            }
        };
        if($req->form['type']){
            $upload->where('type', $req->form['type']);
        };
        // return Counter::with('upload')->get();
        // return Uploads::with('counter')->get();

        $upload = $upload->with('user')->with('counter')->orderBy('created_at', 'DESC')->paginate(15);
        $storage = Uploads::sum('size');
        return [$upload,$storage];
    }
    public function uploadModify(Request $req)
    {
        $form = $req->input('form');
        $type = $req->input('type');
        $upload = Uploads::find($form['id']);
        if($type == 'delete'){
            if($upload->url != 'noimage123.png'){
                if (Storage::exists('/public/uploads/'.$upload->url)) {
                    Storage::delete('/public/uploads/'.$upload->url);
                }
            }
            $upload->delete();
        }else if($type == 'edit'){
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
    public function tagsIndex()
    {
        return view('admin.tags');
    }
    public function tagsFetch()
    {
        return Tags::all();
    }
    public function tagsPost(Request $req)
    {
        $form = $req->input('form');
        if($form['type'] == 'new'){
            $tag = new Tags;
            $tag->name = $form['name'];
            $tag->editor_id = Auth()->user()->id;
            $tag->save();
            $log = new Logmaker;
            $log->user_id = Auth()->user()->id;
            $log->action = 'tag new';
            $log->upload_id = $tag->id;
            $log->info = json_encode($tag);
            $log->save();
        }else if($form['type'] == 'edit'){
            $tag = Tags::find($form['name']);
            $tag->name = $form['input2'];
            $tag->editor_id = Auth()->user()->id;
            $tag->save();
            $log = new Logmaker;
            $log->user_id = Auth()->user()->id;
            $log->action = 'tag edit';
            $log->upload_id = $tag->id;
            $log->info = json_encode($tag);
            $log->save();
        }else if($form['type'] == 'delete'){
            $tag = Tags::find($form['name']);
            $log = new Logmaker;
            $log->user_id = Auth()->user()->id;
            $log->action = 'tag delete';
            $log->upload_id = $tag->id;
            $log->info = json_encode($tag);
            $log->save();
            $tag->delete();
        }
        return "success";
    }
    public function logsIndex()
    {
        return view('admin.logs');
    }
    public function logsFetch(Request $req)
    {
        $logs = Logmaker::with(['user', 'upload'])->orderBy('created_at', 'DESC')->paginate(15);
        return $logs;
    }
}
