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

   

    
    function diverList($div_id)
    {
        $dive = new Dive;

        $list = $dive->getDiversList($div_id);

        $diverArray= json_decode(json_encode($list),true);

        
        return view('diverList',['divers'=>$diverArray]);
        

    }

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

    function historique(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $Usersdives = $dive->diveCurrentUser($dvr_id);
        return view('historique',['dives'=>$Usersdives]);
    }

    function getInfos(){
        $dive = new Dive;
        $div_id = request('div_id');
        $palanquees = request('palanquees');
        $res = $dive->getPDFInfo($div_id);
        //$currentDive = $dive->
        return view('info',['pdfInfo' => $res, 'palanquees' => $palanquees]);
    }

}
