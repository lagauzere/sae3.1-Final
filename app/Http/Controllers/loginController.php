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
        if($res==null){
            session()->flash('erreurCode',-1);
        }
        else{
        $resName = $log->selectName($licence);
        $resLvl = $log->getUserLevel($licence);
        session()->flash('erreurCode',0);
        session(['userName'=> $resName, 'userID'=> $res, 'userLevel'=> $resLvl]);
        }
        return view('welcome'); 
      
}

public function Disconnection(){
    session()->forget('userID'); 
    return redirect()->route('welcome'); 
}
}
