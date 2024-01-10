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

   
    function diverList($div_id)
    {
        $dive = new Dive;

        $list = $dive->getDiversList($div_id);

        $diverArray= json_decode(json_encode($list),true);

        return view('diverList',['divers'=>$diverArray]);
        

    }

}
