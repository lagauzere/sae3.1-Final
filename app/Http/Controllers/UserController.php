<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Views\Components;

class UserController extends Controller
{
    public function getRemainingCredits()
    {
        $user = new User;
        #$remainingCredits = $user->remainingCredits(session('userID'));
        $remainingCredits = $user->remainingCredits("A-04-100004");
        
        #return view('components.user-credits',['credit_amount' => $remainingCredits]);
        return $remainingCredits;
    }

    public function getInscription($div_id){

        $licence = session('userID');
        $user = new user;
        $result = $user->checkRegistration($licence,$div_id);

         return view('test',['result'=>$result]);
        
        }
}