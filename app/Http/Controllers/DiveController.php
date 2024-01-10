<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Http\Request;


class DiveController extends Controller
{
    //
    function index()
    {
        $DiverModel = new Dive;

        $diveAvailable = $DiverModel->diveAvailable();
        $diveAvailableArray = json_decode(json_encode($diveAvailable),true);
        $user = session()->get('user');

        $everyDivesRegistered = $DiverModel->everyDivesTheDiverIsRegisteredIn($user);
        $everyDivesRegisteredArray = json_decode(json_encode($everyDivesRegistered),true);
        
        return view('diveslists', [
            'dives' => $diveAvailableArray,
            'everyDivesRegistered' => $everyDivesRegisteredArray
        ]);
    }

   

    
    function diverList($div_id)
    {
        $dive = new Dive;

        $list = $dive->getDiversList($div_id);

        $diverArray= json_decode(json_encode($list),true);

        return view('diverList',['divers'=>$diverArray]);
        

    }

    function historique(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $Usersdives = $dive->diveCurrentUser($dvr_id);
        return view('historique',['dives'=>$Usersdives]);
    }


}
