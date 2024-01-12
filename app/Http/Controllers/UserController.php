<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Views\Components;


/**
 * Controller handling user-related actions.
 */

class UserController extends Controller
{

    /**
     * Get the remaining credits for the logged-in user.
     *
     * @return mixed
     */

    public function getRemainingCredits()
    {
        $user = new User;
        $remainingCredits = $user->remainingCredits(session('userID'));
        #$remainingCredits = $user->remainingCredits("A-04-100004");
        
        #return view('components.user-credits',['credit_amount' => $remainingCredits]);
        return $remainingCredits;
    }

     /**
     * Search for people based on a given query.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function searchPeople(Request $request)
    {
        $query = $request->input('query');
        // Perform a database query to fetch people matching the search query
        $people = User::getPeopleLike($query);

        return response()->json($people);
    }
    public function searchPeopleNotInDive(Request $request)
    {
        $query = $request->input('query');
        $dive = $request->input('dive');
        // Perform a database query to fetch people matching the search query
        $people = User::getPeopleLikeNotInDive($query,$dive);

        return response()->json($people);
    }

     /**
     * Get the registration status of the logged-in user for a specific dive.
     *
     * @param int $div_id Dive ID
     * @return \Illuminate\Contracts\View\View
     */
    
    public function getInscription($div_id){

        $licence = session('userID');
        $user = new user;
        $result = $user->checkRegistration($licence,$div_id);
         return view('divelists',['result'=>$result]);
        
        }
    /**
     * Get a list of all users.
     *
     * @return \Illuminate\Contracts\View\View
     */    

        public function getAllUsers(){
            $user = new user;
            $result = $user->selectAllUsers();
            return view('allUsers',['result'=>$result]);
        }

    /**
     * Update the role/status of a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $dvr_licence User's license
     * @return \Illuminate\Http\RedirectResponse
     */

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




/**
 
 *
 * @param \Illuminate\Http\Request $request
 *     The request object containing user input, particularly the new password and password confirmation.
 *
 * @return \Illuminate\Http\RedirectResponse
 *     If the provided password is empty or does not match the password confirmation,
 *     the function redirects to the 'changePwd' route with an error code.
 *     If the password is valid, it updates the user's password using the `updatePass` method
 *     and redirects to the 'welcome' route.
 * @example
 *     $userController = new UserController();
 *     $response = $userController->updatePassword($request);
 */
public function updatePassword(Request $request){
    $user = new User();

    // Check if password is empty or doesn't match confirmation
    if ($request->input('password') === "" || $request->input('password') != $request->input('passwordCheck')) {
        // Flash an error code to the session
        session()->flash('erreurCode', -1);

        // Redirect to the 'changePwd' route
        return redirect()->route('changePwd');
    } else {
        // Get the password from the request
        $password = $request->input('password');

        // Update user password using the updatePass method
        $user->updatePass($password);

        // Redirect to the 'welcome' route
        return redirect()->route('welcome');
    }
}

}


