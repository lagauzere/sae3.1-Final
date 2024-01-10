<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dive;

class divesInscriptionController extends Controller
{
    
    public function registerDiverInTimeSlot($selectedDive){
        $user = session()->get('userID');
        $DiverModel = new Dive;
        $DiverModel->registerDiverInTimeSlot($user,$selectedDive);
        return redirect()->route('enterTimeSlot', ['selectedDive' => $selectedDive]);
    }   

    public function retireFromTimeSlot($selectedDive){
        $user = session()->get('user');
        $DiverModel = new Dive;
        $DiverModel->retireFromTimeSlot($user,$selectedDive);
        return redirect()->route('enterTimeSlot',['selectedDive' => $selectedDive]);
    }
    
    public function isDiverRegistered($selectedDive){
        $user = session()->get('user');
        $DiverModel = new Dive;
        $res = $DiverModel->isDiverRegistered($user,$selectedDive);
        return view('diveslists',['isDiverRegistered' => $res]);
    }

    public function checkDivesDirector($selectedDive){
        $user = session()->get('userID');
        $DiverModel=new Dive;
        $res = $DiverModel->getDivesDirector($selectedDive);
    }

}
