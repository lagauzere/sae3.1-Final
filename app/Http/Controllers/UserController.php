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
        #$remainingCredits = $user->remainingCredits(session('id'));
        $remainingCredits = $user->remainingCredits(1001);
        
        return view('components.user-credits',['credit_amount' => $remainingCredits]);
    }
}