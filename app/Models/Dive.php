<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class Dive extends Model
{
    use HasFactory;
    function registerDiverInTimeSlot($dvr_id,$div_id){
        $count = DB::select('SELECT COUNT(*) as count FROM PARTICIPATE WHERE DVR_LICENCE = ? and DIV_ID = ?',[$dvr_id,$div_id]);
        $array = json_decode(json_encode($count),true);
        if($array[0]['count'] ==0){
            DB::insert('INSERT INTO PARTICIPATE (DVR_LICENCE,DIV_ID,PAR_CANCELLED) VALUES (?, ?, ?)', [$dvr_id,$div_id,0]);
        }
        else{
            return "Vous vous êtes déjà inscrit et avez annuler votre participation à cette plongée, vous ne pouvez pas vous réinscrire";
        }
    }

    function retireFromTimeSlot($dvr_id, $div_id){

        DB::update('UPDATE PARTICIPATE SET PAR_CANCELLED= 1 WHERE DVR_LICENCE = ? and DIV_ID = ?',[$dvr_id,$div_id]);
    }

    function isDiverRegistered($dvr_id,$div_id){
        return DB::select('select par_cancelled from PARTICIPATE where dvr_licence = ? and div_id = ? ',[$dvr_id,$div_id]);
    }

    public function diveAvailable(){
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_LABEL FROM DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.sta_id = 1 and DIV_DATE > SYSDATE()');
    }    

    //limited to 30 last
    public function diveFinished(){
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
    //limited to 30 last
    public function diveCancelled(){
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

    public function directedPlannedDiveList($dvr_id){
        return DB::select('SELECT DIV_ID, SHP_NAME, SIT_NAME, DLV_DESC, DIV_DATE, DLV_LABEL, (SELECT count(*) FROM PARTICIPATE WHERE PARTICIPATE.DIV_ID = DIVES.DIV_ID AND PAR_CANCELLED = FALSE) COUNT FROM DIVES
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        WHERE DVR_LICENCE_DIRECTS =?
        AND STA_ID = 1
        ORDER BY DIV_DATE DESC', [$dvr_id]);
    }
    
    public function countParticipants($div_id){
        return DB::select('SELECT count(*) count FROM PARTICIPATE JOIN DIVERS using(DVR_LICENCE) WHERE DIV_ID =?', [$div_id]);
    }


    public function getDiversList($div_id){
        return DB:: select('select DVR_NAME,DVR_FIRST_NAME from DIVERS where DVR_LICENCE in (select DVR_LICENCE from PARTICIPATE where DIV_ID=?);',[$div_id]);
    }

    public function selectUsersDives($dvr_id){
        return DB::select('SELECT DIV_ID FROM PARTICIPATE WHERE DVR_LICENCE =?', [$dvr_id]);
    }

    public static function getParticipants($div_id){
        $result = DB::select('SELECT DVR_LICENCE, DVR_FIRST_NAME, DVR_NAME, DLV_LABEL, TRL_LABEL, PAR_CANCELLED FROM DIVERS
        JOIN PARTICIPATE using(DVR_LICENCE) 
        JOIN TRAINING_LEVELS using (TRL_ID)
        JOIN DIVING_LEVELS using (DLV_ID)
        WHERE DIV_ID =?', [$div_id]);
        return json_decode(json_encode($result),true);
    }


    public function showDive($div_id){
        return DB::select('SELECT DIV_ID,DIV_COMMENT,DIV_DATE, SIT_ID, SHP_ID FROM DIVES WHERE DIV_ID =?', [$div_id]);
    }

    public function showSiteName($sit_id){
        return DB::select('SELECT SIT_NAME FROM SITES WHERE SIT_ID =?', [$sit_id]);
    }

    public function showShipName($shp_id){
        return DB::select('SELECT SHP_NAME FROM SHIPS WHERE SHP_ID =?', [$shp_id]);
    }

    public function diveCurrentUser($userID){
        return DB::select('select shp_name, sit_name, DVR_FIRST_NAME, dvr_name, DIV_DATE, DLV_DESC from PARTICIPATE pa
        join DIVES using (DIV_ID)
        join SITES using (sit_id)
        join SHIPS using (shp_id)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.dlv_id = DIVES.dlv_id)
        where pa.dvr_licence = ?', [$userID]);
    }

    public function everyDivesTheDiverIsRegisteredIn($dvr_id){
        
        
    $result = DB::select('SELECT * FROM PARTICIPATE WHERE DVR_LICENCE = ?', [$dvr_id]);
    return $result;
    }

    public static function isDiveDirector($div_id){
        $uid = session('userID');
        if(is_null($uid))
        {
            return -1;
        }
        $result = DB:: select('SELECT count(*) COUNT from DIVES where DIV_ID =? AND DVR_LICENCE_DIRECTS = ?;',[$div_id, $uid]);
        return json_decode(json_encode($result),true)[0]["COUNT"];
    }

    public function getNbInDives($div_id){
        return DB::select('SELECT count(*) as count from PARTICIPATE where DIV_ID =?;',[$div_id]);
    }

}

