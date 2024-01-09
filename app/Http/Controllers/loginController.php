<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;

class loginController extends Controller
{
    public function Connection(Request $request){

        $licence = $request->input('licence');
        $password = $request->input('password');


        $log = new Login;
        $res = $log->selectUser($licence,$password);
        session()->flash('userID', $res);
        if($res){
            return view('welcome'); 
        }
        return view('login');
    }
}
