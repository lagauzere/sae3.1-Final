<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Login extends Model
{
    use HasFactory;
    public function selectUser($licence, $password)
    {
        $result = DB::select('select DVR_LICENCE from DIVERS where DVR_LICENCE = ? and DVR_PASSWORD = ?', [$licence, $password]);
        if (!empty($result)) {
            $licenceValue = $result[0]->DVR_LICENCE;
            return $licenceValue;
        } else {
            return null;
        }
    }

    public function selectName($licence){
        $result = DB::select('select DVR_NAME from DIVERS where DVR_LICENCE = ?', [$licence]);
    if (!empty($result)) {
        return $result;
    } else {
        return null;
    }
    }

    public function getUserLevel($licence){
        return DB::select('select DLV_ID from DIVERS where DVR_LICENCE = ?',[$licence]);
    }

}
