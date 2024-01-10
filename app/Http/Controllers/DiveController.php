<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Http\Request;


class DiveController extends Controller
{
    //
    function index()
    {
        $dives = new Dive;

        $diveAvailable = $dives->diveAvailable();
        $diveAvailableArray = json_decode(json_encode($diveAvailable),true);
        return view('diveslists', [
            'dives' => $diveAvailableArray
        ]);
    }

    

   
    function diverList()
    {
        $dive = new Dive;

        $list = $dive->getDiversList(1);

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
