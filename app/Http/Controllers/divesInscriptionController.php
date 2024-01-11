<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dive;

class DivesInscriptionController extends Controller
{
    
    /**
     * Register a diver in a specific time slot.
     *
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerDiverInTimeSlot(Request $req)
    {
        $user = session()->get('userID');


        $selectedDive = $req->input('selectedDive');


        $diverModel = new Dive;


        $diverModel->registerDiverInTimeSlot($user, $selectedDive);


        return redirect()->route('viewDivesList');
    }   

    /**
     * Retire a diver from a specific time slot.
     *
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retireFromTimeSlot(Request $req)
    {

        $user = session()->get('userID');


        $selectedDive = $req->input('selectedDive');


        $diverModel = new Dive;


        $diverModel->retireFromTimeSlot($user, $selectedDive);


        return redirect()->route('viewDivesList');
    }
    
    /**
     * Check if a diver is registered for a specific dive.
     *
     * @param int $selectedDive
     * @return \Illuminate\View\View
     */
    public function isDiverRegistered($selectedDive)
    {

        $user = session()->get('user');


        $diverModel = new Dive;


        $res = $diverModel->isDiverRegistered($user, $selectedDive);


        return view('diveslists', ['isDiverRegistered' => $res]);
    }

    /**
     * Check if the current user is a dive director.
     *
     * @return bool
     */
    public function checkDivesDirector()
    {

        $user = session()->get('userID');


        $diverModel = new Dive;


        $res = $diverModel->getDivesDirector(1);


        if ($user == $res) {
            return true;
        }
    }
}
