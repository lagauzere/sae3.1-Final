<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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


    public function remainingCredits($userid)
    {
        // Replace with your actual SQL, make sure to use DB::raw() for raw expressions
        $query = DB::table('PARTICIPATE')  
        ->selectRaw('99-count(*) as remaining_credits')
        ->join('DIVES', 'DIVES.div_id', '=', 'PARTICIPATE.div_id')
        ->where('PARTICIPATE.DVR_LICENCE','=',$userid)
        ->whereRaw("DATEDIFF(DIVES.div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')),'%d-%m-%Y')) >= 0")
        ->whereRaw("DATEDIFF(DIVES.div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')+1),'%d-%m-%Y')) < 0")
        ->where('DIVES.STA_ID','!=', 3);
       
        return json_decode(json_encode(($query->get()[0])),true)['remaining_credits'];
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
}
