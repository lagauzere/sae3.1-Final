<?php

namespace App\Http\Controllers;

use App\Models\EditDiveParameters;
use Illuminate\Http\Request;


class EditDiveParametersController extends Controller
{
    //
    function index($id)
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

        $participantsDivingLevels = $dives->getParticipantsDivingLevels($id);

        $availableLevels = $minimumLevel->divingLevelsTest()->filter(function ($level)
        use ($participantsDivingLevels) {
            foreach ($participantsDivingLevels as $participantLevel) {
                if ($participantLevel->DLV_ID < $level->DLV_ID) {
                    return false; 
                }
            }
            return true;
        });

        $minimumLevelArray = json_decode(json_encode($availableLevels), true);

        $dive = $dives->dive($id);
        if(empty($dive)){
            return redirect('/');
        }
        $diveArray = json_decode(json_encode($dive),true);

        $diveDriver = $divesDriver->diveDriver($id);
        $diveDriverArray = json_decode(json_encode($diveDriver),true);

        $diveMonitor = $divesMonitor->diveMonitor($id);
        $diveMonitorArray = json_decode(json_encode($diveMonitor),true);

        // $minimumLevel = $minimumLevel->divingLevels();
        // $minimumLevelArray = json_decode(json_encode($minimumLevel),true);

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

        

        return view('diveParameters', [
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
        $choiceDivingLevelValue = $request->input('choiceDivingLevel');
        $diveId = $request->input('diveNumber');

        // Récupère les niveaux de plongée des participants
        $participantsDivingLevels = $changeData->getParticipantsDivingLevels($diveId);
        // Vérifie si tous les participants ont un niveau supérieur à celui choisi
        foreach ($participantsDivingLevels as $participantLevel) {
            if ($participantLevel->DLV_ID <= $choiceDivingLevelValue) {
                // Redirection avec un message d'erreur si au moins un participant a un niveau inférieur ou égal

                session()->flash('error','Impossible d\'augmenter le niveau, tous les participants doivent avoir un niveau supérieur.');
                return redirect()->back();
            }
        }
        
        $changeData->updateDiveMonitor($diveId, $choiceMonitorValue);
        $changeData->updateDiveShip($diveId, $choiceBoatValue);
        $changeData->updateDiveDirector($diveId, $choiceDirectorValue);
        $changeData->updateDiveSite($diveId, $choiceSiteValue);
        $changeData->updateDiveDriver($diveId, $choiceDriverValue);
        $changeData->updateDiveDivingLevel($diveId, $choiceDivingLevelValue);

        return redirect('/');
    }

    
}