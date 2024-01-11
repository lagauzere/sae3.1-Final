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


        $dive = $dives->dive($id);
        if (empty($dive)) {
            return redirect('/');
        }
        $diveArray = json_decode(json_encode($dive), true);

        $diveDriver = $divesDriver->diveDriver($id);
        $diveDriverArray = json_decode(json_encode($diveDriver), true);

        $diveMonitor = $divesMonitor->diveMonitor($id);
        $diveMonitorArray = json_decode(json_encode($diveMonitor), true);

        $minimumLevel = $minimumLevel->divingLevels();
        $minimumLevelArray = json_decode(json_encode($minimumLevel), true);

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
        $numberMaxValue = $request->input('numberMax');
        $choiceDivingLevelValue = $request->input('choiceDivingLevel');
        $diveId = $request->input('diveNumber');

        // Update dive parameters in the database
        $changeData->updateDiveMonitor($diveId, $choiceMonitorValue);
        $changeData->updateDiveShip($diveId, $choiceBoatValue);
        $changeData->updateDiveDirector($diveId, $choiceDirectorValue);
        $changeData->updateDiveSite($diveId, $choiceSiteValue);
        $changeData->updateDiveDriver($diveId, $choiceDriverValue);
        $changeData->updateDiveHeadcount($diveId, $numberMaxValue);
        $changeData->updateDiveDivingLevel($diveId, $choiceDivingLevelValue);

        // Redirect to the home page after updating
        return redirect('/');
    }
}
