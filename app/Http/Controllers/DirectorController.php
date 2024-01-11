<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class DirectorController extends BaseController
{
    public function directedPlannedDiveList()
    {
        
        $dvr_id = session('userID');
        $dive = new Dive;

        $listNum = $dive->directedPlannedDiveList($dvr_id);

        $diveArray = json_decode(json_encode($listNum),true);

        $completeDiveArray=array();
        
        
        foreach($diveArray as $diveNumber) {
            array_push($completeDiveArray, $diveNumber);
        }
        return view('directorDivesList',['dives'=>$completeDiveArray]);

    }
    /*
    public function checkDivesDirector($div_id){
        $user = session('userID');
        $DiverModel=new Dive;
        $res = $DiverModel->getDivesDirector($div_id);
        var_dump($res);
        return ($user==$res);
        
    }
    */
    public function handleFormChangeParticipationStateSubmission(Request $request)
    {
        $uid = $request->input('uid');
        $div_id = $request->input('div_id');
        $wanted_state = $request->input('wanted_state');
        
        User::updateParticipationState($uid, $div_id, $wanted_state);
        
        return $this->editDivers($request);
    }

    public function handleFormAddParticipationSubmission(Request $request)
    {
        $uid = $request->input('uid');
        $div_id = $request->input('div_id');
        
        User::addParticipation($uid, $div_id);
        
        return $this->editDivers($request);
    }

    public function handleFormRemoveParticipationSubmission(Request $request)
    {
        $uid = $request->input('uid');
        $div_id = $request->input('div_id');
        
        User::removeParticipation($uid, $div_id);
        
        return $this->editDivers($request);
    }
    
    public function editDivers(Request $request){
        $div_id = $request->input('div_id');

        $participants = Dive::getParticipants($div_id);

        if(Dive::isDiveDirector($div_id)){
            return view('directorEditDivers',['div_id'=>$div_id, 'participants'=>$participants]);
        }
        return redirect()->route('welcome'); 
    }
}
