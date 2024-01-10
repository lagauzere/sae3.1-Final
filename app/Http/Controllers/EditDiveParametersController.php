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

        $dive = $dives->dive();
        $diveArray = json_decode(json_encode($dive),true);
        $diveDriver = $divesDriver->diveDriver();
        $diveDriverArray = json_decode(json_encode($diveDriver),true);
        $diveMonitor = $divesMonitor->diveDriver();
        $diveMonitorArray = json_decode(json_encode($diveMonitor),true);
        return view('diveparameters', [
            'divesparameters' => $diveArray,
            'divesDriver' => $diveDriverArray,
            'divesMonitor' => $diveMonitorArray
        ]);
    }
}