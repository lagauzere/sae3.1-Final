<?php

namespace App\Http\Controllers;

use App\Models\EditDiveParameters;
use Illuminate\Http\Request;

/**
 * Class EditDiveParametersController
 * @package App\Http\Controllers
 */
class EditDiveParametersController extends Controller
{
    /**
     * Display the dive parameters for editing.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index($id)
    {
        // Create instances of EditDiveParameters for different data retrieval
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
        if (empty($dive)) {
            return redirect('/');
        }
        $diveArray = json_decode(json_encode($dive), true);

        $diveDriver = $divesDriver->diveDriver($id);
        $diveDriverArray = json_decode(json_encode($diveDriver), true);

        $diveMonitor = $divesMonitor->diveMonitor($id);
        $diveMonitorArray = json_decode(json_encode($diveMonitor), true);

        // $minimumLevel = $minimumLevel->divingLevels();
        // $minimumLevelArray = json_decode(json_encode($minimumLevel),true);

        $boatName = $boatName->ships();
        $boatNameArray = json_decode(json_encode($boatName), true);

        $siteName = $siteName->sites();
        $siteNameArray = json_decode(json_encode($siteName), true);

        $directorName = $directorName->directors();
        $directorNameArray = json_decode(json_encode($directorName), true);

        $driverName = $driverName->drivers();
        $driverNameArray = json_decode(json_encode($driverName), true);

        $monitorName = $monitorName->monitors();
        $monitorNameArray = json_decode(json_encode($monitorName), true);

        

        // Pass data to the diveParameters view
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

    /**
     * Update dive parameters based on user input.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeDataDives(Request $request)
    {
        // Create an instance of EditDiveParameters for updating data
        $changeData = new EditDiveParameters();

        // Get user input values
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

        // Redirect to the home page after updating
        return redirect('/');
    }

    
}
