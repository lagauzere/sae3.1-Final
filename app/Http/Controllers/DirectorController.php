<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeleteDive;

/**
 * Class DirectorController
 * @package App\Http\Controllers
 */
class DirectorController extends BaseController
{
    /**
     * Display a list of planned dives directed by the currently logged-in user.
     *
     * @return \Illuminate\View\View
     */
    public function directedPlannedDiveList()
    {

        $dvr_id = session('userID');


        $dive = new Dive;


        $listNum = $dive->directedPlannedDiveList($dvr_id);


        $diveArray = json_decode(json_encode($listNum), true);


        $completeDiveArray = array();


        foreach ($diveArray as $diveNumber) {
            array_push($completeDiveArray, $diveNumber);
        }


        return view('directorDivesList', ['dives' => $completeDiveArray]);
    }


    
    /**
     * Handle the form submission to change the participation state of a user in a dive.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function handleFormChangeParticipationStateSubmission(Request $request)
    {

        $uid = $request->input('uid');
        $div_id = $request->input('div_id');
        $wanted_state = $request->input('wanted_state');


        User::updateParticipationState($uid, $div_id, $wanted_state);


        return $this->editDivers($request);
    }


    
    /**
     * Display a view to edit divers participating in a dive.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editDivers(Request $request)
    {

        $div_id = $request->input('div_id');


        $participants = Dive::getParticipants($div_id);

        $div_date = Dive::getDate($div_id);


        if (Dive::isDiveDirector($div_id)) {

            return view('directorEditDivers', ['div_id' => $div_id, 'participants' => $participants, 'div_date'=>$div_date]);
        }

        return redirect()->route('welcome');
    }

    public function deleteDiver(Request $request){
        $div_id = $request->input('div_id');

        $deleteDive = new DeleteDive();

        $deleteDive->deleteDive($div_id);

        return redirect('directedplanneddiveslist');
    }
}
