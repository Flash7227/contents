<?php

namespace App\Http\Controllers;

use App\Uploads;
use App\User;
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
        $users = User::paginate(10);
        return $users;
    }


    public function userEdit(Request $request){
        if($request->input('delete')){
            $user = User::find($request->input('id'));
            if($user->delete()){
                return 'success';
            };
        }else{
            $form = $request->input('form');
            if(isset($form['id'])){
                $user = User::find($form['id']);
            }else{
                $user = new User;
            }
            // if($user = User::create([
            //     'name' => $request['form']['name'],
            //     'email' => $request['form']['email'],
            //     'permissions' => json_encode($request['form']['permissions']),
            //     'role' => $request['form']['role'],
            //     'password' => Hash::make($request['form']['password']),
            // ])
            // ){
            //     return "user created successfuly";
            // }
            
                // return $form['password'];
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

    public function profileIndex(){
        return view('admin.profile');
    }

    public function profileUpload(Request $req){
        $data =  Auth::user();

        return [$data];
    }

    public function uploadIndex()
    {
        return view('admin.uploads');
    }
    public function uploadFetch(Request $req)
    {
        $upload = Uploads::with('user')->orderBy('created_at', 'DESC')->paginate(15);
        $storage = Uploads::sum('size');
        return [$upload,$storage];
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
            // $upload->name = $form['name'];
            // $upload->desc = $form['desc'];
            // $upload->sharetype = $form['sharetype'];
            // $tags = [];
            // if($form['dynamicTags']){
            //     // $tags = explode(",", $form['dynamicTags']);
            //     $tags = $form['dynamicTags'];
            // };
            // $allowed = [];
            // if($form['allowed']){
            //     // $allowed = explode(",", $form['allowed']);
            //     $allowed = $form['allowed'];
            // }
            // $upload->tags = json_encode($tags);
            // $upload->allowed = json_encode($allowed);
            // $upload->save();
        }
        return "success";
    }
}
