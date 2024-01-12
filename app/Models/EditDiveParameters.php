<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class EditDiveParameters
 * @package App\Models
 */
class EditDiveParameters extends Model
{
    use HasFactory;

/**
 * Retrieve dive parameters based on the provided ID.
 *
 * @param int $id
 * @return array
 */
    public function dive($id){
        return DB::select("select DIV_ID, SHP_SEATS,SHP_NAME, STA_LABEL, SIT_NAME, SIT_DEPTH, DLV_LABEL, 
        DIV_DATE, DLV_DESC, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER, 
        DVR_LICENCE_MONITORS, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, DIV_HEADCOUNT
        from DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.STA_ID = 1 and DIV_ID = ? and DIV_DATE > SYSDATE()", [$id]);
    }

    /**
     * Retrieve dive parameters for a dive driver based on the provided ID.
     *
     * @param int $id
     * @return array
     */
    public function diveDriver($id)
    {
        return DB::select("select DIV_ID, STA_LABEL, 
            DIV_DATE, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER,
            DVR_LICENCE_DRIVES
            from DIVES
            join STATUS using (STA_ID)
            join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DRIVES)
            where STATUS.STA_ID = 1 and DIV_ID = ? and DIV_DATE > SYSDATE()", [$id]);
    }

    /**
     * Retrieve dive parameters for a dive monitor based on the provided ID.
     *
     * @param int $id
     * @return array
     */
    public function diveMonitor($id)
    {
        return DB::select("select DIV_ID, STA_LABEL, 
            DIV_DATE, concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER,
            DVR_LICENCE_MONITORS
            from DIVES
            join STATUS using (STA_ID)
            join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_MONITORS)
            where STATUS.STA_ID = 1 and DIV_ID = ? and DIV_DATE > SYSDATE()", [$id]);
    }

    /**
     * Retrieve available diving levels.
     *
     * @return array
     */
    public function divingLevels()
    {
        return DB::select("select DLV_LABEL, DLV_ID from DIVING_LEVELS");
    }

/**
 * Retrieve available dive sites.
 *
 * @return array
 */
    public function sites(){
        return DB::select("select SIT_NAME, SIT_ID, SIT_DEPTH from SITES");
    }

        /**
     * Retrieve available ships.
     *
     * @return array
     */
    public function ships(){
        return DB::select("select SHP_NAME, SHP_ID, SHP_SEATS from SHIPS");
    }

    /**
     * Retrieve available monitors.
     *
     * @return array
     */
    public function monitors()
    {
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
            where DVR_CANMONITOR");
    }

    /**
     * Retrieve available directors.
     *
     * @return array
     */
    public function directors()
    {
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
            where DVR_CANDIRECT");
    }

    /**
     * Retrieve available drivers.
     *
     * @return array
     */
    public function drivers()
    {
        return DB::select("select distinct concat(DVR_NAME,' ' , DVR_FIRST_NAME) as DIVER, DVR_LICENCE from DIVERS
            where DVR_CANDRIVE");
    }

    /**
     * Update dive monitor for a specific dive.
     *
     * @param int $diveId
     * @param string $choiceMonitorValue
     * @return int
     */
    public function updateDiveMonitor($diveId, $choiceMonitorValue)
    {
        return DB::update("update DIVES set DVR_LICENCE_MONITORS = '$choiceMonitorValue' where DIV_ID = $diveId");
    }

    /**
     * Update dive ship for a specific dive.
     *
     * @param int $diveId
     * @param int $choiceBoatValue
     * @return int
     */
    public function updateDiveShip($diveId, $choiceBoatValue)
    {
        return DB::update("update DIVES set SHP_ID = $choiceBoatValue where DIV_ID = $diveId");
    }

    /**
     * Update dive director for a specific dive.
     *
     * @param int $diveId
     * @param string $choiceDirectorValue
     * @return int
     */
    public function updateDiveDirector($diveId, $choiceDirectorValue)
    {
        return DB::update("update DIVES set DVR_LICENCE_DIRECTS = '$choiceDirectorValue' where DIV_ID = $diveId");
    }

    /**
     * Update dive site for a specific dive.
     *
     * @param int $diveId
     * @param int $choiceSiteValue
     * @return int
     */
    public function updateDiveSite($diveId, $choiceSiteValue)
    {
        return DB::update("update DIVES set SIT_ID = $choiceSiteValue where DIV_ID = $diveId");
    }

    /**
     * Update dive driver for a specific dive.
     *
     * @param int $diveId
     * @param string $choiceDriverValue
     * @return int
     */
    public function updateDiveDriver($diveId, $choiceDriverValue)
    {
        return DB::update("update DIVES set DVR_LICENCE_DRIVES = '$choiceDriverValue' where DIV_ID = $diveId");
    }

    /**
     * Update dive headcount for a specific dive.
     *
     * @param int $diveId
     * @param int $numberMaxValue
     * @return int
     */
    public function updateDiveHeadcount($diveId, $numberMaxValue)
    {
        return DB::update("update DIVES set DIV_HEADCOUNT = $numberMaxValue where DIV_ID = $diveId");
    }

    /**
     * Update dive diving level for a specific dive.
     *
     * @param int $diveId
     * @param int $choiceDivingLevelValue
     * @return int
     */
    public function updateDiveDivingLevel($diveId, $choiceDivingLevelValue)
    {
        return DB::update("update DIVES set DLV_ID = $choiceDivingLevelValue where DIV_ID = $diveId");
    }

    public function getHeadcount($shp_ID){
        return DB::select('SELECT SHP_SEATS FROM ships WHERE SHP_ID = ?', [$shp_ID]);
    }

    
}
