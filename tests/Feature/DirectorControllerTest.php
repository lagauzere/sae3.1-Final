<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Dive;
use App\Models\User;
class DirectorControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDirectedPlannedDiveList()
    {
        $response = $this->get('/directedplanneddiveslist');
        $response->assertSuccessful();
    }

    public function testHandleFormChangeParticipationStateSubmission()
    {
        $response = $this->post('/handle-form-change-participation-state', [
            'uid' => 1,
            'div_id' => 123,
            'wanted_state' => 1,
        ]);
        $response->assertViewIs('directorEditDivers');
    }

    public function testHandleFormAddParticipationSubmission()
    {
        $response = $this->post('/handle-form-add-participation', [
            'uid' => 1,
            'div_id' => 123,
        ]);
        $response->assertSuccessful();
    }


    public function testHandleFormRemoveParticipationSubmission()
    {
        $response = $this->post('/handle-form-remove-participation', [
            'uid' => 1,
            'div_id' => 123,
        ]);
        $response->assertSuccessful();
    }
    public function testEditDivers()
    {
        DB::table('DIVERS')->insertGetId([
            'DVR_LICENCE' => 'A-04-100050',
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
    
        $dvrId = 'A-04-100050';

        DB::table('DIVES')->insertGetId([
            'DIV_ID'=>60,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité'
        ]);
        $divId = 60;

        

        $response = $this->post('/directorDive', ['div_id' => $divId]);

        $response->assertSuccessful();
    }

    public function testDeleteDiver()
    {
        DB::table('DIVERS')->insertGetId([
            'DVR_LICENCE' => 'A-04-100050',
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
    
        $dvrId = 'A-04-100050';

        DB::table('DIVES')->insertGetId([
            'DIV_ID'=>60,
            'DVR_LICENCE_MONITORS' => 'A-04-100003',
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'SHP_ID' => 1,
            'STA_ID' => 1,
            'DLV_ID' => 5,
            'SIT_ID' => 6,
            'DIV_DATE' => '2024-04-10 09:00:00',
            'DIV_HEADCOUNT' => 8,
            'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité'
        ]);
        $divId = 60;

        $response = $this->post('/handle-form-remove-participation', ['div_id' => $divId]);

        $response->assertSuccessful();
}

}

?>