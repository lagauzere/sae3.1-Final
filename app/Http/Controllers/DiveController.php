<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dive;
use Illuminate\Http\Request;
use App\Models\EditDiveParameters;



/**
 * Controller handling actions related to dives.
 */


class DiveController extends Controller
{
    /**
     * Display the list of available dives and the ones the diver is registered in.
     *
     * @return \Illuminate\Contracts\View\View
     */

    function index()
    {
        $DiverModel = new Dive;

        $diveAvailable = $DiverModel->diveAvailable();
        $diveAvailableArray = json_decode(json_encode($diveAvailable),true);

        $user = session()->get('userID');
        $userLevel = session()->get('userLevel');

        $everyDivesRegistered = $DiverModel->everyDivesTheDiverIsRegisteredIn($user);
        $everyDivesRegisteredArray = json_decode(json_encode($everyDivesRegistered),true);
        
        return view('diveslists', [
            'dives' => $diveAvailableArray,
            'everyDivesRegistered' => $everyDivesRegisteredArray,
            'userLevel' => $userLevel
        ]);
    }

   
    /**
     * Display the list of divers registered for a specific dive.
     *
     * @param int $div_id Dive ID
     * @return \Illuminate\Contracts\View\View
     */
    
    function diverList($div_id)
    {
        $dive = new Dive;
        $list = $dive->getDiversList($div_id);
        $diverArray= json_decode(json_encode($list),true);
        return view('diverList',['divers'=>$diverArray]);
    }

    /**
     * Display the list of directed planned dives by the logged-in user.
     *
     * @return \Illuminate\Contracts\View\View
     */

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

    function historique(){
        $dvr_id = session('userID');
        $dive = new Dive;
        
        $Usersdives = $dive->diveCurrentUser($dvr_id);
        return view('historique',['dives'=>$Usersdives]);
    }

    function getInfos(){
        $dive = new Dive;
        $div_id = request('div_id');
        $res = $dive->getPDFInfo($div_id);
        return view('info',['pdfInfo' => $res]);
    }

    function creationDive(){
        $minimumLevel = new EditDiveParameters();
        $boatName = new EditDiveParameters();
        $siteName = new EditDiveParameters();
        $directorName = new EditDiveParameters();
        $driverName = new EditDiveParameters();
        $monitorName = new EditDiveParameters();

        $minimumLevel = $minimumLevel->divingLevels();
        $minimumLevelArray = json_decode(json_encode($minimumLevel),true);

        $boatName = $boatName->ships();
        $boatNameArray = json_decode(json_encode($boatName),true);

        $siteName = $siteName->sites();
        $siteNameArray = json_decode(json_encode($siteName),true);

        $directorName = $directorName->directors();
        $directorNameArray = json_decode(json_encode($directorName),true);

        $driverName = $driverName->drivers();
        $driverNameArray = json_decode(json_encode($driverName),true);

        $monitorName = $monitorName->monitors();
        $monitorNameArray = json_decode(json_encode($monitorName),true);

        return view('creationDive',[
        'minimumLevel' => $minimumLevelArray,
        'boatName' => $boatNameArray,
        'siteName' => $siteNameArray,
        'directorName' => $directorNameArray,
        'driverName' => $driverNameArray,
        'monitorName' => $monitorNameArray,
        ]);
    }

    public function creationDataDives(Request $request) {

        $creationData = new Dive();

        $choiceBoatValue = $request->input('choiceBoat');
        $choiceSiteValue = $request->input('choiceSite');
        $choiceDirectorValue = $request->input('choiceDirector');
        $choiceDriverValue = $request->input('choiceDriver');
        $choiceMonitorValue = $request->input('choiceMonitor');
        $choiceDivingLevelValue = $request->input('choiceDivingLevel');
        $choiceHours = $request->input('choiceHours');
        $choiceDate = $request->input('date');
        $comment = $request->input('comment');

        $shipHeadcountResult = $creationData->getHeadcount($choiceBoatValue);
        $shipHeadcountResultArray = json_decode(json_encode($shipHeadcountResult),true);
        $shipHeadcount = implode($shipHeadcountResultArray[0]);
        $date = $choiceDate.' '.$choiceHours;

        $idResult = $creationData->getMaxDiveID();
        $idResultDD = json_decode(json_encode($idResult),true);
        $id = implode($idResultDD[0]);
        
        $creationData->createDive($id, $choiceBoatValue, $choiceSiteValue, $choiceDirectorValue, $choiceDriverValue, $choiceMonitorValue, $choiceDivingLevelValue, $date, $shipHeadcount, $comment);

        return redirect('/');
    }
}
