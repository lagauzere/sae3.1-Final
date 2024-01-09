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
        $result = DB::select('select dvr_licence from divers where dvr_licence = ? and dvr_password = ?', [$licence, $password]);
        if (!empty($result)) {
            $licenceValue = $result[0]->dvr_licence;
            return $licenceValue;
        } else {
            return null;
        }
    }


}
