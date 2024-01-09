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


}
