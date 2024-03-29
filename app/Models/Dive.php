<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Dive
 * @package App\Models
 */
class Dive extends Model
{
    use HasFactory;

    /**
     * Register a diver in a specific time slot.
     *
     * @param int $dvr_id
     * @param int $div_id
     * @return string|null
     */
    public function registerDiverInTimeSlot($dvr_id, $div_id)
    {
        $count = DB::select('SELECT COUNT(*) as count FROM PARTICIPATE WHERE DVR_LICENCE = ? and DIV_ID = ?', [$dvr_id, $div_id]);
        $array = json_decode(json_encode($count), true);

        if ($array[0]['count'] == 0) {
            DB::insert('INSERT INTO PARTICIPATE (DVR_LICENCE, DIV_ID, PAR_CANCELLED) VALUES (?, ?, ?)', [$dvr_id, $div_id, 0]);
            DB::update('UPDATE DIVES SET DIV_HEADCOUNT = (SELECT DIV_HEADCOUNT FROM DIVES WHERE DIV_ID = ? ) -1 WHERE DIV_ID = ? ', [$div_id, $div_id]);
        } else {
            return "Vous vous êtes déjà inscrit et avez annulé votre participation à cette plongée, vous ne pouvez pas vous réinscrire";
        }

        return null;
    }

    /**
     * Remove a diver from a specific time slot.
     *
     * @param int $dvr_id
     * @param int $div_id
     */
    public function retireFromTimeSlot($dvr_id, $div_id)
    {
        DB::update('UPDATE PARTICIPATE SET PAR_CANCELLED= 1 WHERE DVR_LICENCE = ? and DIV_ID = ?', [$dvr_id, $div_id]);
        DB::update('UPDATE DIVES SET DIV_HEADCOUNT = (SELECT DIV_HEADCOUNT FROM DIVES WHERE DIV_ID = ? ) +1 WHERE DIV_ID = ? ', [$div_id, $div_id]);
    }

    /**
     * Check if a diver is registered for a specific time slot.
     *
     * @param int $dvr_id
     * @param int $div_id
     * @return array
     */
    public function isDiverRegistered($dvr_id, $div_id)
    {
        return DB::select('select par_cancelled from PARTICIPATE where dvr_licence = ? and div_id = ? ', [$dvr_id, $div_id]);
    }

    /**
     * Retrieve the list of available dives.
     *
     * @return array
     */
    public function diveAvailable()
    {
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_LABEL, DIVING_LEVELS.DLV_ID, DIV_HEADCOUNT FROM DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.sta_id = 1 and DIV_DATE > SYSDATE()');
    }

    /**
     * Retrieve the list of finished dives (limited to the last 30).
     *
     * @return array
     */
    public function diveFinished()
    {
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC FROM DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.STA_ID = 2 and DIV_DATE > SYSDATE()
        ORDER BY DIV_DATE DESC
        LIMIT 30;');
    }

    /**
     * Retrieve the list of cancelled dives (limited to the last 30).
     *
     * @return array
     */
    public function diveCancelled()
    {
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC FROM DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.STA_ID = 3 and DIV_DATE > SYSDATE()
        ORDER BY DIV_DATE DESC
        LIMIT 30;');
    }

    public static function getDate($div_id){
        $result = DB::select('SELECT DIV_DATE FROM DIVES
        WHERE DIV_ID =?', [$div_id]);
        return json_decode(json_encode($result),true);
    }

    /**
     * Retrieve the list of planned dives directed by a specific diver.
     *
     * @param int $dvr_id
     * @return array
     */
    public function directedPlannedDiveList($dvr_id)
    {
        return DB::select('SELECT DIV_ID, SHP_NAME, SIT_NAME, DLV_DESC, DIV_DATE, DLV_LABEL, (SELECT count(*) FROM PARTICIPATE WHERE PARTICIPATE.DIV_ID = DIVES.DIV_ID AND PAR_CANCELLED = FALSE) COUNT FROM DIVES
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        WHERE DVR_LICENCE_DIRECTS =?
        AND STA_ID = 1
        ORDER BY DIV_DATE DESC', [$dvr_id]);
    }

    public function allPlannedDiveList(){
        return DB::select('SELECT DIV_ID, SHP_NAME, SIT_NAME, DLV_DESC, DIV_DATE, DLV_LABEL, (SELECT count(*) FROM PARTICIPATE WHERE PARTICIPATE.DIV_ID = DIVES.DIV_ID AND PAR_CANCELLED = FALSE) COUNT FROM DIVES
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        WHERE STA_ID = 1
        ORDER BY DIV_DATE DESC');
    }
    
    /**
     * Retrieve the participant count for a specific dive.
     *
     * @param int $div_id
     * @return array
     */
    public function countParticipants($div_id)
    {
        return DB::select('SELECT count(*) count FROM PARTICIPATE JOIN DIVERS using(DVR_LICENCE) WHERE DIV_ID =?', [$div_id]);
    }

    public static function numParticipantsNotCancelled($div_id)
    {
        $res = DB::select('SELECT count(*) count FROM PARTICIPATE JOIN DIVERS using(DVR_LICENCE) WHERE DIV_ID =? AND PAR_CANCELLED = 0', [$div_id]);
        return json_decode(json_encode($res[0]),true)['count'];
    }


    /**
     * Retrieve the list of divers participating in a specific dive.
     *
     * @param int $div_id
     * @return array
     */
    public function getDiversList($div_id)
    {
        return DB::select('select DVR_NAME, DVR_FIRST_NAME from DIVERS where DVR_LICENCE in (select DVR_LICENCE from PARTICIPATE where DIV_ID=?);', [$div_id]);
    }

    /**
     * Retrieve the list of dives a specific user is registered for.
     *
     * @param int $dvr_id
     * @return array
     */
    public function selectUsersDives($dvr_id)
    {
        return DB::select('SELECT DIV_ID FROM PARTICIPATE WHERE DVR_LICENCE =?', [$dvr_id]);
    }



    /**
     * Retrieve the participants for a specific dive.
     *
     * @param int $div_id
     * @return array
     */
    public static function getParticipants($div_id)
    {
        $result = DB::select('SELECT DVR_LICENCE, DVR_FIRST_NAME, DVR_NAME, DLV_LABEL, TRL_LABEL, PAR_CANCELLED FROM DIVERS
        JOIN PARTICIPATE using(DVR_LICENCE) 
        JOIN TRAINING_LEVELS using (TRL_ID)
        JOIN DIVING_LEVELS using (DLV_ID)
        WHERE DIV_ID =?', [$div_id]);

        return json_decode(json_encode($result), true);
    }

    /**
     * Retrieve information about a specific dive.
     *
     * @param int $div_id
     * @return array
     */
    public function showDive($div_id)
    {
        return DB::select('SELECT DIV_ID, DIV_COMMENT, DIV_DATE, SIT_ID, SHP_ID FROM DIVES WHERE DIV_ID =?', [$div_id]);
    }

    /**
     * Retrieve the site name for a specific site ID.
     *
     * @param int $sit_id
     * @return array
     */
    public function showSiteName($sit_id)
    {
        return DB::select('SELECT SIT_NAME FROM SITES WHERE SIT_ID =?', [$sit_id]);
    }

    /**
     * Retrieve the ship name for a specific ship ID.
     *
     * @param int $shp_id
     * @return array
     */
    public function showShipName($shp_id)
    {
        return DB::select('SELECT SHP_NAME FROM SHIPS WHERE SHP_ID =?', [$shp_id]);
    }

    /**
     * Retrieve the dives a specific user is currently registered for.
     *
     * @param int $userID
     * @return array
     */
    public function diveCurrentUser($userID)
    {
        return DB::select('select shp_name, sit_name, DVR_FIRST_NAME, dvr_name, DIV_DATE, DLV_LABEL,DLV_DESC, STA_ID from PARTICIPATE pa
        join DIVES using (DIV_ID)
        join SITES using (sit_id)
        join SHIPS using (shp_id)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.dlv_id = DIVES.dlv_id)
        where pa.dvr_licence = ?
        order by DIV_DATE asc', [$userID]);
    }

    public function currentDive($div_id){
        return DB::select(' = ?', [$div_id]);
    }

    /**
     * Retrieve all the dives a specific diver is registered for.
     *
     * @param int $dvr_id
     * @return array
     */
    public function everyDivesTheDiverIsRegisteredIn($dvr_id)
    {
        return DB::select('SELECT * FROM PARTICIPATE WHERE DVR_LICENCE = ?', [$dvr_id]);
    }

    /**
     * Check if the current user is the dive director for a specific dive.
     *
     * @param int $div_id
     * @return int
     */
    public static function isDiveDirector($div_id)
    {
        $uid = session('userID');

        if (is_null($uid)) {
            return -1;
        }

        $result = DB::select('SELECT count(*) COUNT from DIVES where DIV_ID =? AND DVR_LICENCE_DIRECTS = ?;', [$div_id, $uid]);

        return json_decode(json_encode($result), true)[0]["COUNT"];
    }

    public function getHeadcount($shp_ID){
        return DB::select('SELECT SHP_SEATS FROM SHIPS WHERE SHP_ID = ?', [$shp_ID]);
    }

    public function getMaxDiveID(){
        return DB::select('SELECT (MAX(DIV_ID)+1) as DIV_ID from DIVES');
    }

    public function getDiveSameDay($date){
        return DB::select('SELECT count(*) as count FROM DIVES WHERE DIV_DATE = ?', [$date]);
    }

    public function createDive($id, $choiceBoatValue, $choiceSiteValue, $choiceDirectorValue, $choiceDriverValue, $choiceMonitorValue, $choiceDivingLevelValue, $date, $shipHeadcount, $comment) {
        return DB::insert("INSERT INTO DIVES(DIV_ID, DVR_LICENCE_MONITORS, SHP_ID, DVR_LICENCE_DIRECTS, DVR_LICENCE_DRIVES, STA_ID, DLV_ID, SIT_ID, DIV_DATE, DIV_HEADCOUNT, DIV_COMMENT) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $id, $choiceMonitorValue, $choiceBoatValue, $choiceDirectorValue, $choiceDriverValue, 1, $choiceDivingLevelValue, $choiceSiteValue, $date, $shipHeadcount, $comment
        ]);
    }
    /**
     * Retrieve the number of participants in a specific dive.
     *
     * @param int $div_id
     * @return array
     */
    public function getNbInDives($div_id){
        return DB::select('SELECT count(*) as count from PARTICIPATE where DIV_ID =?;',[$div_id]);
    }

    public function getAllTheDivesInTheDay($date){
        return DB::select('SELECT COUNT(*) as count FROM DIVES WHERE DIV_DATE like ?',[$date . '%']);
    }

    public function getDivesAtTheSameHours($date){
        return DB::select('SELECT COUNT(*) as count FROM DIVES WHERE DIV_DATE like ?',[$date]);

    }
    public function getPDFInfo($div_id) {
        return DB::select('SELECT DIV_DATE, concat(dir.DVR_FIRST_NAME, " ", dir.DVR_NAME) AS DIRECTS, SIT_NAME, (24 - DIV_HEADCOUNT) AS HEADCOUNT, concat(mon.DVR_FIRST_NAME, " ", mon.DVR_NAME) AS MONITORS, DIV_COMMENT FROM DIVES 
        JOIN DIVERS  dir ON dir.DVR_LICENCE = DIVES.DVR_LICENCE_DIRECTS
        JOIN DIVERS  mon ON mon.DVR_LICENCE = DIVES.DVR_LICENCE_MONITORS
        JOIN SITES USING (SIT_ID)
        WHERE DIV_ID = ?', [$div_id]);
    }

}
