<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LDAP\Result;

class Dive extends Model
{
    use HasFactory;
    function registerDiverInTimeSlot($dvr_id,$div_id){
        DB::insert('INSERT INTO PARTICIPATE (DVR_LICENCE,DIV_ID,PAR_CANCELLED) VALUES (?, ?, ?)', [$dvr_id,$div_id,0]);
    }

    public function diveAvailable(){
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC FROM DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.sta_id = 1 and DIV_DATE > SYSDATE()');
    }    

    //limited to 30 last
    public function diveFinished(){
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC FROM DIVES
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
        return DB::select('SELECT DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC FROM DIVES
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
        return DB::select('SELECT count(*) count FROM PARTICIPATE WHERE DIV_ID =?', [$div_id]);
    }


    public function getDiversList($div_id){
        return DB:: select('select DVR_NAME,DVR_FIRST_NAME from DIVERS where DVR_LICENCE in (select DVR_LICENCE from PARTICIPATE where DIV_ID=?);',[$div_id]);
    }

    public function selectUsersDives($dvr_id){
        return DB::select('SELECT DIV_ID FROM PARTICIPATE WHERE DVR_LICENCE =?', [$dvr_id]);
    }

    public function showDive($div_id){
        return DB::select('SELECT DIV_ID,DIV_COMMENT,DIV_DATE FROM DIVES WHERE DIV_ID =?', [$div_id]);
    }

}

