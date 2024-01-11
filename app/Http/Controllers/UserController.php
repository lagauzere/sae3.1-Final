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

    public function searchPeople(Request $request)
    {
        $query = $request->input('query');
        // Perform a database query to fetch people matching the search query
        $people = User::getPeopleLike($query);

        return response()->json($people);
    }
}