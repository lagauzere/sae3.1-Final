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
        $remainingCredits = $user->remainingCredits(session('userID'));
        #$remainingCredits = $user->remainingCredits("A-04-100004");
        
        #return view('components.user-credits',['credit_amount' => $remainingCredits]);
        return $remainingCredits;
    }

    public function isDirector()
    {
        $uid = session('userID');
        if(is_null($uid))
        {
            return -1;
        }
        $user = new User;
        $can_direct = $user->canDirect(session('userID'));

        return $can_direct;
    }
}