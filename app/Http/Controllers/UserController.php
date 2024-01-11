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

    
    public function getInscription($div_id){

        $licence = session('userID');
        $user = new user;
        $result = $user->checkRegistration($licence,$div_id);

         return view('test',['result'=>$result]);
        
        }


        public function getAllUsers(){
            $user = new user;
            $result = $user->selectAllUsers();
            return view('allUsers',['result'=>$result]);
        }



        public function updateRole(Request $request,$dvr_licence){
            if($request->input('isPilote')=='on'){
                $pilot = 1;
            }else{
                $pilot = 0;
            }

            
            if($request->input('isDirector')){
                $director = 1;
            }else{
                $director = 0;
            }
            if($request->input('isManager')){
                $manager = 1;
            }else{
                $manager = 0;
            }

            if($request->input('isAdmin')){
                $isAdmin = 1;
            }else{
                $isAdmin = 0;
            }

            $user = new user;
            $user->updateUserStatus($pilot,$manager,$director,  $isAdmin, $dvr_licence);
            return redirect()->route('users'); 
        }

}