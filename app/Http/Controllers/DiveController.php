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
        
        // foreach($array as $dive){
        //    echo $dive["DIV_ID"].'<br>';
        // }
        
        // dd($array);
        return view('diveslists', [
            'dives' => $diveAvailableArray
        ]);
    }
}
