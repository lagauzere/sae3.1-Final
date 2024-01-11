<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Http\Request;



/**
 * Controller handling actions related to dives.
 */


class DiveController extends Controller
{
    /**
     * Display the list of available dives and the ones the diver is registered in.
     *
     * @return \Illuminate\Contracts\View\View
     */

    function index()
    {
        $DiverModel = new Dive;

        $diveAvailable = $DiverModel->diveAvailable();
        $diveAvailableArray = json_decode(json_encode($diveAvailable),true);
        $user = session()->get('userID');
        $userLevel = session()->get('userLevel');
        $everyDivesRegistered = $DiverModel->everyDivesTheDiverIsRegisteredIn($user);
        $everyDivesRegisteredArray = json_decode(json_encode($everyDivesRegistered),true);
        
        return view('diveslists', [
            'dives' => $diveAvailableArray,
            'everyDivesRegistered' => $everyDivesRegisteredArray,
            'userLevel' => $userLevel
        ]);
    }

   
    /**
     * Display the list of divers registered for a specific dive.
     *
     * @param int $div_id Dive ID
     * @return \Illuminate\Contracts\View\View
     */
    
    function diverList($div_id)
    {
        $dive = new Dive;

        $list = $dive->getDiversList($div_id);

        $diverArray= json_decode(json_encode($list),true);

        
        return view('diverList',['divers'=>$diverArray]);
        

    }

    /**
     * Display the list of directed planned dives by the logged-in user.
     *
     * @return \Illuminate\Contracts\View\View
     */

    function directedPlannedDiveList()
    {
        $dvr_id = session('userID');
        $dive = new Dive;

        $listNum = $dive->directedPlannedDiveList($dvr_id);

        $diveArray = json_decode(json_encode($listNum),true);

        $completeDiveArray=array();
        
        
        foreach($diveArray as $diveNumber) {
            array_push($completeDiveArray, $diveNumber);
        }
        return view('directorDivesList',['dives'=>$completeDiveArray]);

    }

    /**
     * Display the dive history of the logged-in user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    function historique(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $Usersdives = $dive->diveCurrentUser($dvr_id);
        return view('historique',['dives'=>$Usersdives]);
    }


}
