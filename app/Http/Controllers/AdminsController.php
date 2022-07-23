<?php

namespace App\Http\Controllers;

use App\Uploads;
use App\User;
use Storage;
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
                        'permissions' => ($request['form']['permissions']),
                        'role' => $request['form']['role'],
                        'storage_limit' => $request['form']['storage_limit'],
                        'password' => Hash::make($request['form']['password']),
                    ]);
                }else {
                    $user->fill(
                        [
                            'name' => $request['form']['name'],
                            'email' => $request['form']['email'],
                            'permissions' => ($request['form']['permissions']),
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


    
}
