<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dive;

class divesInscriptionController extends Controller
{
    
    public function registerDiverInTimeSlot(Request $req){
        $user = session()->get('userID');
        $selectedDive = $req->input('selectedDive');
        $DiverModel = new Dive;
        $DiverModel->registerDiverInTimeSlot($user,$selectedDive);
    
        return redirect()->route('viewDivesList');
    }   

    public function retireFromTimeSlot(Request $req){
        $user = session()->get('userID');
        $selectedDive = $req->input('selectedDive');
        $DiverModel = new Dive;
        $DiverModel->retireFromTimeSlot($user,$selectedDive);
        return redirect()->route('viewDivesList');
    }
    
    public function isDiverRegistered($selectedDive){
        $user = session()->get('user');
        $DiverModel = new Dive;
        $res = $DiverModel->isDiverRegistered($user,$selectedDive);
        return view('diveslists',['isDiverRegistered' => $res]);
    }


}
