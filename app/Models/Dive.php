<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dive extends Model
{
    use HasFactory;
    function registerDiverInTimeSlot($dvr_id,$div_id){
        DB::insert('insert into participate (dvr_licence,div_id,par_cancelled) values (?, ?, ?)', [$dvr_id,$div_id,0]);
    }
}
