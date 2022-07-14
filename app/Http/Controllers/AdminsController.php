<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function usersIndex()
    {
        return view('admin.users');
    }
}
