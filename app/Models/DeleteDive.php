<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LDAP\Result;

class DeleteDive extends Model
{
    use HasFactory;

    public function deleteDive($id){
        return DB::delete("delete from DIVES where DIV_ID = ?", [$id]);
    }
}