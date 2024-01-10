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
        return DB::select("select DIV_ID, SHP_NAME, STA_LABEL, SIT_NAME, DLV_DESC, 
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
        return DB::select("select concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER
        from DIVES
        join STATUS using (STA_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DRIVES)
        where STATUS.STA_ID = 1 and DIV_ID = 2 and DIV_DATE > SYSDATE()");
    }

    public function diveMonitor(){
        return DB::select("select concat(DIVERS.DVR_NAME,' ',DIVERS.DVR_FIRST_NAME) as DIVER
        from DIVES
        join STATUS using (STA_ID)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_MONITORS)
        where STATUS.STA_ID = 1 and DIV_ID = 2 and DIV_DATE > SYSDATE()");
    }
}