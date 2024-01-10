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

    function historique(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $listNum = $dive->selectUsersDives($dvr_id);

        //list of user's dives ID
        $diveArray = json_decode(json_encode($listNum),true);

        $completeDiveArray = array();
        $completeSiteArray = array();
        $completeShipArray = array();
        foreach($diveArray as $diveRow) {
            //going from an array of dive id to an array of fully detailed dives
            $diveNumber = $diveRow['DIV_ID'];
            $currentDive = $dive->showDive($diveNumber);
            array_push($completeDiveArray, $currentDive);
            
            /*$currentShip = $dive->showShipName($currentDive[0]['SHP_ID']);
            array_push($completeSiteArray, $currentSite);
            array_push($completeShipArray, $currentShip);*/
            
        }
        $realArrayDiv=json_decode(json_encode($completeDiveArray),true);
        $currentSite = $dive->showSiteName($realArrayDiv[0]['SIT_ID']);
        /*$realArraySit=json_decode(json_encode($completeSiteArray),true);
        $realArrayShp=json_decode(json_encode($completeShipArray),true);*/

        return view('profile',['dives'=>$realArrayDiv]);

        //return view('profile',['dives'=>$realArrayDiv], ['sites'=>$realArraySit], ['ships'=>$realArrayShp]);
    }


}
