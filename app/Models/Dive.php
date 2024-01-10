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
        return DB::select('select div_id, shp_name, sta_label, sit_name, dlv_desc, dvr_name, DVR_FIRST_NAME, DIV_DATE, DLV_DESC from DIVES
        join STATUS using (sta_id)
        join SITES using (sit_id)
        join SHIPS using (shp_id)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.dlv_id = DIVES.dlv_id)
        where STATUS.STA_ID = 1 and DIV_DATE > SYSDATE()');
        // return DB::table('DIVES')->join('STATUS', 'STATUS.STA_ID', '=', 'DIVES.STA_ID')->where('DIVES.STA_ID', '=', 1)->where('DIVES.DIV_DATE', '>', 'SYSDATE()')->get();
    } 
    
    public function getDiversList($div_id){
        return DB:: select('select DVR_NAME,DVR_FIRST_NAME from DIVERS where DVR_LICENCE in (select DVR_LICENCE from PARTICIPATE where DIV_ID=?);',[$div_id]);
    }

    public function selectUsersDives($dvr_id){
        return DB::select('SELECT DIV_ID FROM PARTICIPATE WHERE DVR_LICENCE =?', [$dvr_id]);
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
        return DB::select('select shp_name, sit_name, DVR_FIRST_NAME, dvr_name, DIV_DATE, DLV_DESC from participate pa
        join dives using (DIV_ID)
        join SITES using (sit_id)
        join SHIPS using (shp_id)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.dlv_id = DIVES.dlv_id)
        where pa.dvr_licence = ?', [$userID]);
    }

}

