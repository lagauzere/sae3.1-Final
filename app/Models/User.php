<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function remainingCredits($dvr_id)
    {
        // Replace with your actual SQL, make sure to use DB::raw() for raw expressions
        $query = DB::table('PARTICIPATE')  
        ->selectRaw('99-count(*) as remaining_credits')
        ->join('DIVES', 'DIVES.div_id', '=', 'PARTICIPATE.div_id')
        ->where('PARTICIPATE.DVR_LICENCE','=',$dvr_id)
        ->whereRaw("DATEDIFF(DIVES.div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')),'%d-%m-%Y')) >= 0")
        ->whereRaw("DATEDIFF(DIVES.div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')+1),'%d-%m-%Y')) < 0")
        ->where('DIVES.STA_ID','!=', 3);
       
        return json_decode(json_encode(($query->get()[0])),true)['remaining_credits'];
    }

    public static function canDirect(){

        $uid = session('userID');
        if(is_null($uid))
        {
            return -1;
        }
        $result = DB::select('SELECT DVR_CANDIRECT as can_direct FROM DIVERS WHERE DVR_LICENCE =?', [$uid]);
        
        return json_decode(json_encode($result),true)[0]["can_direct"];
    
    }

    public function checkStatus(){

    }

    public function checkRegistration($dvr_licence,$div_id){
        $res= DB::select('select count(*) from PARTICIPATE where DVR_LICENCE=? and DIV_ID=? ',[$dvr_licence,$div_id]);

        if($res == 1){
            return true;
        }
        return false;
    }

    public static function updateParticipationState($uid,$div_id, $state)
    {
        //dd($uid,$div_id, $state);
        return DB::update("update PARTICIPATE set PAR_CANCELLED = ? where DIV_ID = ? AND DVR_LICENCE = ?",[$state,$div_id,$uid]);
    }

    public static function getPeopleLike($name)
    {
        $result = DB::select('select DVR_FIRST_NAME, DVR_NAME, DVR_LICENCE from DIVERS where UPPER(CONCAT(DVR_FIRST_NAME," ",DVR_NAME)) LIKE UPPER(CONCAT("%",?,"%")) LIMIT 10',[$name]);
        return json_decode(json_encode($result),true);
    }
    public static function removeParticipation($uid,$div_id)
    {
        return DB::delete("DELETE FROM  PARTICIPATE where DIV_ID = ? AND DVR_LICENCE = ?",[$div_id,$uid]);
    }
}
