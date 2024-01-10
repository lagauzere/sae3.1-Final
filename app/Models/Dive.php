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

    function retireFromTimeSlot($dvr_id, $div_id){
        DB::update('update participate set par_cancelled = 0 where dvr_licence = ? and div_id = ?',[$dvr_id,$div_id]);
    }

    function isDiverRegistered($dvr_id,$div_id){
        return DB::select('select par_cancelled from participate where dvr_licence = ? and div_id = ? ',[$dvr_id,$div_id]);
    }

    public function diveAvailable(){
        return DB::select('select DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, DVR_NAME, DVR_FIRST_NAME, DIV_DATE, DLV_DESC from DIVES
        join STATUS using (STA_ID)
        join SITES using (SIT_ID)
        join SHIPS using (SHP_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join DIVING_LEVELS on (DIVING_LEVELS.DLV_ID = DIVES.DLV_ID)
        where STATUS.STA_ID = 1 and DIV_DATE > SYSDATE()');
        // return DB::table('DIVES')->join('STATUS', 'STATUS.STA_ID', '=', 'DIVES.STA_ID')->where('DIVES.STA_ID', '=', 1)->where('DIVES.DIV_DATE', '>', 'SYSDATE()')->get();
    } 
    
    public function getDiversList($div_id){
        return DB:: select('select DVR_NAME,DVR_FIRST_NAME from DIVERS where DVR_LICENCE in (select DVR_LICENCE from PARTICIPATE where DIV_ID=?);',[$div_id]);
    }

}

