<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getRemainingCredits()
    {
        $user = new User;
        #$remainingCredits = $user->remainingCredits(session('id'));
        $remainingCredits = $user->remainingCredits(1001);
        return response()->json($remainingCredits);
    }
}