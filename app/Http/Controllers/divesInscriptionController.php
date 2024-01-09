<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dive;

class divesInscriptionController extends Controller
{
 
    public function registerDiverInTimeSlot(){
        $DiverModel = new Dive;
        $DiverModel->registerDiverInTimeSlot(1001,1);
    }

}
