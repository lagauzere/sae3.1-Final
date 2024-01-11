<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Login
 * @package App\Models
 */
class Login extends Model
{
    use HasFactory;

    /**
     * Select user based on provided license and password.
     *
     * @param string $licence
     * @param string $password
     * @return string|null
     */
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

    /**
     * Select user's name based on provided license.
     *
     * @param string $licence
     * @return array|null
     */
    public function selectName($licence)
    {
        $result = DB::select('select DVR_NAME from DIVERS where DVR_LICENCE = ?', [$licence]);
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Get user level based on provided license.
     *
     * @param string $licence
     * @return array
     */
    public function getUserLevel($licence)
    {
        return DB::select('select DLV_ID from DIVERS where DVR_LICENCE = ?', [$licence]);
    }
}
