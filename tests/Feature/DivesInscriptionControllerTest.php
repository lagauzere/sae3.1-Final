<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dive;
use App\Models\User;
use App\Http\Controllers\divesInscriptionController;
use Illuminate\Support\Facades\DB;

class DivesInscriptionControllerTest extends TestCase
{
    use DatabaseTransactions;

   /* public function testRegisterDiverInTimeSlot()
    {
        
        $divId = 60;
        $userId = 'A-04-100050';

        DB::table('DIVES')->insert([
            'DIV_ID' => $divId,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité',
        ]);

        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userId,
            'DLV_ID' => 5,
            'PAS_ID' => 1,
            'TRL_ID' => 1,
            'DVR_NAME' => 'DiverName',
            'DVR_FIRST_NAME' => 'DiverFirstName',
            'DVR_MC_DATE' => '2018-05-21',
            'DVR_PASSWORD' => 'password123',
            'DVR_ACTIVE' => true,
            'DVR_ISADMIN' => false,
            'DVR_CANDRIVE' => false,
            'DVR_CANMONITOR' => true,
            'DVR_CANDIRECT' => false,
        ]);

        $response = $this->post('/diveslists', [
            'selectedDive' => $divId,
        ]);

        $response->assertDatabaseHas('participate', ['DVR_LICENCE' => $userId, 'DIV_ID' => $divId]);
    }
*/
    public function testRetireFromTimeSlot()
    {

        $divId = 60;
        $userId = 'A-04-100050';

        DB::table('DIVES')->insert([
            'DIV_ID' => $divId,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité',
        ]);

        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userId,
            'DLV_ID' => 5,
            'PAS_ID' => 1,
            'TRL_ID' => 1,
            'DVR_NAME' => 'DiverName',
            'DVR_FIRST_NAME' => 'DiverFirstName',
            'DVR_MC_DATE' => '2018-05-21',
            'DVR_PASSWORD' => 'password123',
            'DVR_ACTIVE' => true,
            'DVR_ISADMIN' => false,
            'DVR_CANDRIVE' => false,
            'DVR_CANMONITOR' => true,
            'DVR_CANDIRECT' => false,
        ]);

        $this->post('/diveslists', [
            'selectedDive' => $divId,
        ]);

        $response = $this->post('/retire', [
            'selectedDive' => $divId,
        ]);

        $response->assertRedirect(route('viewDivesList'));
    }
/*  
    public function testIsDiverRegistered()
    {
     
        $divId = 60;
        $userId = 'A-04-100050';

        DB::table('DIVES')->insert([
            'DIV_ID' => $divId,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité',
        ]);

        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userId,
            'DLV_ID' => 5,
            'PAS_ID' => 1,
            'TRL_ID' => 1,
            'DVR_NAME' => 'DiverName',
            'DVR_FIRST_NAME' => 'DiverFirstName',
            'DVR_MC_DATE' => '2018-05-21',
            'DVR_PASSWORD' => 'password123',
            'DVR_ACTIVE' => true,
            'DVR_ISADMIN' => false,
            'DVR_CANDRIVE' => false,
            'DVR_CANMONITOR' => true,
            'DVR_CANDIRECT' => false,
        ]);

        $response = $this->post('/diveslists', [
            'selectedDive' => $divId,
        ]);

        $response->assertRedirect(route('viewDivesList'));    }

  public function testCheckDivesDirector()
    {

        $divId = 60;
        $directorId = 'A-04-100002';

        DB::table('DIVES')->insert([
            'DIV_ID' => $divId,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => $directorId,
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité',
        ]);


        $controller = new divesInscriptionController();
        $result = $controller->checkDivesDirector();

    }*/
}
