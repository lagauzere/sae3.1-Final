<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LDAP\Result;

class EditDiveParameters extends Model
{
    use HasFactory;

    public function dive(){
        return DB::select("select DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_LABEL, 
        DIV_DATE, DLV_DESC, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER, 
        DVR_LICENCE_MONITORS, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, DIV_HEADCOUNT
        from DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.STA_ID = 1 and DIV_ID = 2 and DIV_DATE > SYSDATE()");
    }

    public function diveDriver(){
        return DB::select("select DIV_ID, STA_LABEL, 
        DIV_DATE, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER,
        DVR_LICENCE_DRIVES
        from DIVES
        join STATUS using (STA_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DRIVES)
        where STATUS.STA_ID = 1 and DIV_ID = 2 and DIV_DATE > SYSDATE()");
    }

    public function diveMonitor(){
        return DB::select("select DIV_ID, STA_LABEL, 
        DIV_DATE, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER,
        DVR_LICENCE_MONITORS
        from DIVES
        join STATUS using (STA_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_MONITORS)
        where STATUS.STA_ID = 1 and DIV_ID = 2 and DIV_DATE > SYSDATE()");
    }

    public function divingLevels(){
        return DB::select("select DLV_LABEL, DLV_ID from DIVING_LEVELS");
    }

    public function sites(){
        return DB::select("select SIT_NAME, SIT_ID from SITES");
    }

    public function ships(){
        return DB::select("select SHP_NAME, SHP_ID from SHIPS");
    }

    public function monitors(){
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
        where DVR_CANMONITOR");
    }

    public function directors(){
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
        where DVR_CANDIRECT");
    }

    public function drivers(){
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
        where DVR_CANDRIVE");
    }

    public function updateDiveMonitor($diveId, $choiceMonitorValue){
        return DB::update("update DIVES set DVR_LICENCE_MONITORS = '$choiceMonitorValue' where DIV_ID = $diveId");
    }

    public function updateDiveShip($diveId, $choiceBoatValue){
        return DB::update("update DIVES set SHP_ID = $choiceBoatValue where DIV_ID = $diveId");
    }

    public function updateDiveDirector($diveId, $choiceDirectorValue){
        return DB::update("update DIVES set DVR_LICENCE_DIRECTS = '$choiceDirectorValue' where DIV_ID = $diveId");
    }

    public function updateDiveSite($diveId, $choiceSiteValue){
        return DB::update("update DIVES set SIT_ID = $choiceSiteValue where DIV_ID = $diveId");
    }

    public function updateDiveDriver($diveId, $choiceDriverValue){
        return DB::update("update DIVES set DVR_LICENCE_DRIVES = '$choiceDriverValue' where DIV_ID = $diveId");
    }

    public function updateDiveHeadcount($diveId, $numberMaxValue){
        return DB::update("update DIVES set DIV_HEADCOUNT = $numberMaxValue where DIV_ID = $diveId");
    }

    public function updateDiveDivingLevel($diveId, $choiceDivingLevelValue){
        return DB::update("update DIVES set DLV_ID = $choiceDivingLevelValue where DIV_ID = $diveId");
    }
}