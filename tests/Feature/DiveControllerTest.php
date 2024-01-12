<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dive;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DiveControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {   
        $user = new User([
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
    
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testDiverList()
    {
        $response = $this->get('/diverlist/1'); 
        $response->assertSuccessful();
        $response->assertViewIs('diverList');
    }

    public function testDirectedPlannedDiveList()
    {
        $response = $this->get('/directedplanneddiveslist');
        $response->assertSuccessful();
        $response->assertViewIs('directorDivesList');
    }

    public function testCreationDive()
    {
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
        $user = new User([
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
    
        $this->actingAs($user);
    
        $response = $this->get('/creationDive');
        $response->assertStatus(200);
    }
    /*
    public function testHistorique()
    {
        $user = new User([
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
    
        $this->actingAs($user);
        $response = $this->get('/historique');
        $response->assertStatus(200);
    }

    public function testCreationDataDives()
    {
        $user = new User([
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
    
        $this->actingAs($user);
        $response = $this->post('/createDataDives', [
        ]);
        $response->assertRedirect('/');
    }
    */

}
