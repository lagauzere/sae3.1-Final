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
        $resName  = $log->selectName($licence);;
        session(['userName'=> $resName, 'userID'=> $res]);
        return view('welcome'); 
      
}

public function Disconnection(){
    session()->forget('userID'); 
    return redirect()->route('welcome'); 
}
}
