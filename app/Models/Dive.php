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
        DB::insert('insert into participate (dvr_licence,div_id,par_cancelled) values (?, ?, ?)', [$dvr_id,$div_id,0]);
    }

    function retireFromTimeSlot($dvr_id, $div_id){
        DB::update('update participate set par_cancelled = 0 where dvr_licence = ? and div_id = ?',[$dvr_id,$div_id]);
    }

    function isDiverRegistered($dvr_id,$div_id){
        return DB::select('select par_cancelled from participate where dvr_licence = ? and div_id = ? ',[$dvr_id,$div_id]);
    }

    public function diveAvailable(){
        return DB::select('select div_id, shp_name, sta_label, sit_name, sit_depth, dvr_name, DVR_FIRST_NAME, DIV_DATE, par_cancelled from DIVES
        join STATUS using (sta_id)
        join SITES using (sit_id)
        join SHIPS using (shp_id)
        join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS)
        join PARTICIPATE using (div_id)
        where STATUS.sta_id = 1 and DIV_DATE > SYSDATE()');
        // return DB::table('DIVES')->join('STATUS', 'STATUS.sta_id', '=', 'DIVES.sta_id')->where('DIVES.STA_ID', '=', 1)->where('DIVES.DIV_DATE', '>', 'SYSDATE()')->get();
    }    
}

