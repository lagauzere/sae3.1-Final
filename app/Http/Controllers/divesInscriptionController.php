<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Dive;

class divesInscriptionController extends Controller
{
 
    public function registerDiverInTimeSlot(){
        Dive::registerDiverInTimeSlot(1001);
    }

}
