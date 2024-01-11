<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;

/**
 * Controller handling user login and logout functionality.
 */

class loginController extends Controller
{
    /**
     * Handles the user login process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */

    public function Connection(Request $request){

        $licence = $request->input('licence');
        $password = $request->input('password');
        $log = new Login;

        $res = $log->selectUser($licence,$password);
        if($res==null){
            session()->flash('erreurCode',-1);
        }
        else{
        $resName  = $log->selectName($licence);;
        session()->flash('erreurCode',0);
        session(['userName'=> $resName, 'userID'=> $res]);
        }
        return view('welcome'); 
      
}

/**
     * Handles the user logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
public function Disconnection(){
    session()->forget('userID'); 
    return redirect()->route('welcome'); 
}
}
