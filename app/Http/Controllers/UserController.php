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


        public function getAllUsers(){
            $user = new user;
            $result = $user->selectAllUsers();
            $diverArray= json_decode(json_encode($result),true);
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

            $user = new user;
            $user->updateUserStatus($pilot,$manager,$director,$dvr_licence);
            return redirect()->route('users'); 
        }

}