<?php

namespace App\Http\Controllers;

use App\Models\Dive;
use Illuminate\Routing\Controller as BaseController;

class DirectorController extends BaseController
{
    function directedPlannedDiveList()
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

    public function editDivers(){
        $div_id = 1;
        if($this->checkDivesDirector($div_id)){
            return view('directorEditDivers',['div_id'=>$div_id]);
        }
        else 
        var_dump($this->checkDivesDirector($div_id));
    }
}
