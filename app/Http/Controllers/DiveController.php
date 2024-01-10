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

   
    function diverList()
    {
        $dive = new Dive;

        $list = $dive->getDiversList(1);

        $diverArray= json_decode(json_encode($list),true);

        return view('diverList',['divers'=>$diverArray]);
        

    }

    function profile(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $listNum = $dive->selectUsersDives($dvr_id);

        $diveArray = json_decode(json_encode($listNum),true);

        $completeDiveArray=array();

        
        foreach($diveArray as $diveNumber) {
            $currentDive = $dive->showDive($diveNumber)[0];
            //array_push($completeDiveArray,$currentDive);
            array_push($completeDiveArray, $diveNumber);
            
        }

        return view('profile',['dives'=>$completeDiveArray]);
    }


}
