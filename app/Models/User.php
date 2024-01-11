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
        $res= DB::select('select count(*) as count from PARTICIPATE where DVR_LICENCE=? and DIV_ID=? ',[$dvr_licence,$div_id]);


        $count =  json_decode(json_encode($res),true);
        if($count[0]['count'] == 1){
            return true;
        }
        
       else{
        return false;
        } 
    }

    public static function updateParticipationState($uid,$div_id, $state)
    {
        return DB::update("update PARTICIPATE set PAR_CANCELLED = ? where DIV_ID = ? AND DVR_LICENCE = ?",[$state,$div_id,$uid]);
    }

    public static function addParticipation($uid,$div_id)
    {
        return DB::insert("INSERT IGNORE INTO PARTICIPATE (DVR_LICENCE, DIV_ID, PAR_CANCELLED) VALUES (?,?,0)",[$uid,$div_id]);
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
    public function selectAllUsers(){
        return DB::select('select * from DIVERS');
    }


    public function updateUserStatus($pilot,$manager,$director, $isAdmin, $dvr_licence){

        DB::update('UPDATE DIVERS SET DVR_CANDRIVE=?,DVR_CANMONITOR=?,DVR_CANDIRECT=? , DVR_ISADMIN=? WHERE DVR_LICENCE=?',[$pilot,$manager,$director,$isAdmin,$dvr_licence]);

    }

    public static function isAdmin()
    {   
        return  json_decode(json_encode(DB::select('select DVR_ISADMIN from DIVERS where DVR_LICENCE=?' ,[session('userID')])),true)[0]['DVR_ISADMIN'];
    }

    public static function isDirector()
    {   
        return  json_decode(json_encode(DB::select('select DVR_ISADMIN from DIVERS where DVR_LICENCE=?' ,[session('userID')])),true)[0]['DVR_CANDIRECT'];
    }

    public static function isUnregister($div_id){

        $res= json_decode(json_encode(DB::select('select count(*) from PARTICIPATE where DVR_LICENCE=? and DIV_ID=? and PAR_CANCELLED=1 ' ,[session('userID'),$div_id])),true)[0]['DVR_CANDIRECT'];
    }

}
