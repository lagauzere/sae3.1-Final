<?php

namespace App\Http\Controllers;

use App\Models\EditDiveParameters;
use Illuminate\Http\Request;


class EditDiveParametersController extends Controller
{
    //
    function index()
    {
        $dives = new EditDiveParameters();
        $divesDriver = new EditDiveParameters();
        $divesMonitor = new EditDiveParameters();
        $minimumLevel = new EditDiveParameters();
        $boatName = new EditDiveParameters();
        $siteName = new EditDiveParameters();
        $directorName = new EditDiveParameters();
        $driverName = new EditDiveParameters();
        $monitorName = new EditDiveParameters();

        $dive = $dives->dive();
        $diveArray = json_decode(json_encode($dive),true);

        $diveDriver = $divesDriver->diveDriver();
        $diveDriverArray = json_decode(json_encode($diveDriver),true);

        $diveMonitor = $divesMonitor->diveMonitor();
        $diveMonitorArray = json_decode(json_encode($diveMonitor),true);

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

        return view('diveparameters', [
            'divesparameters' => $diveArray,
            'divesDriver' => $diveDriverArray,
            'divesMonitor' => $diveMonitorArray,
            'minimumLevel' => $minimumLevelArray,
            'boatName' => $boatNameArray,
            'siteName' => $siteNameArray,
            'directorName' => $directorNameArray,
            'driverName' => $driverNameArray,
            'monitorName' => $monitorNameArray,
        ]);
    }

    public function changeDataDives(Request $request) {

        $changeData = new EditDiveParameters();

        $choiceBoatValue = $request->input('choiceBoat');
        $choiceSiteValue = $request->input('choiceSite');
        $choiceDirectorValue = $request->input('choiceDirector');
        $choiceDriverValue = $request->input('choiceDriver');
        $choiceMonitorValue = $request->input('choiceMonitor');
        $numberMaxValue = $request->input('numberMax');
        $choiceDivingLevelValue = $request->input('choiceDivingLevel');
        $diveId = $request->input('diveNumber');
        
        $changeData->updateDiveMonitor($diveId, $choiceMonitorValue);
        $changeData->updateDiveShip($diveId, $choiceBoatValue);
        $changeData->updateDiveDirector($diveId, $choiceDirectorValue);
        $changeData->updateDiveSite($diveId, $choiceSiteValue);
        $changeData->updateDiveDriver($diveId, $choiceDriverValue);
        $changeData->updateDiveHeadcount($diveId, $numberMaxValue);
        $changeData->updateDiveDivingLevel($diveId, $choiceDivingLevelValue);

        return view('welcome');
    }
}