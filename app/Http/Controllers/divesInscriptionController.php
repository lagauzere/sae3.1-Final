<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dive;

class divesInscriptionController extends Controller
{
    
    public function registerDiverInTimeSlot($selectedDive){
        $user = session()->get('user');
        $DiverModel = new Dive;
        $DiverModel->registerDiverInTimeSlot(1003,$selectedDive);
        return redirect()->route('enterTimeSlot', ['selectedDive' => $selectedDive]);
    }   

}
