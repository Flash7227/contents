<?php

namespace App\Http\Controllers;

use App\Uploads;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            $path = Storage::delete('public/uploads'.$user->avatar);
            $id = Auth::user()->id;
            $user->avatar = $fileNameToStore;
            // return $avatar;
            $user->save();
            return $user;




    }
        
  
}


    

