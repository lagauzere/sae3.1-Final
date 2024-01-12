<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Dive;

class DiveTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegisterAndRetireFromTimeSlot()
{
    $divId = DB::table('DIVES')->insertGetId([
        'DVR_LICENCE_MONITORS' => 'A-04-100003',
        'SHP_ID' => 1,
        'STA_ID' => 1,
        'DLV_ID' => 5,
        'SIT_ID' => 6,
        'DIV_DATE' => '2024-04-10 09:00:00',
        'DIV_HEADCOUNT' => 8,
        'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité'
    ]);

    $dvrId = DB::table('DIVERS')->insertGetId([
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

    $dive = new Dive();
    $result = $dive->registerDiverInTimeSlot($dvrId, $divId);

    $this->assertNotEquals("Vous vous êtes déjà inscrit et avez annulé votre participation à cette plongée, vous ne pouvez pas vous réinscrire", $result);
    $this->assertDatabaseHas('PARTICIPATE', ['DVR_LICENCE' => $dvrId, 'DIV_ID' => $divId, 'PAR_CANCELLED' => 0]);
    $this->assertDatabaseHas('DIVES', ['DIV_ID' => $divId, 'DIV_HEADCOUNT' => 7]);

    $isRegisteredBeforeRetire = $dive->isDiverRegistered($dvrId, $divId);
    $this->assertEquals(0, $isRegisteredBeforeRetire[0]->par_cancelled);

    $dive->retireFromTimeSlot($dvrId, $divId);

    $this->assertDatabaseHas('PARTICIPATE', ['DVR_LICENCE' => $dvrId, 'DIV_ID' => $divId, 'PAR_CANCELLED' => 1]);
    $this->assertDatabaseHas('DIVES', ['DIV_ID' => $divId, 'DIV_HEADCOUNT' => 8]);

    $isRegisteredAfterRetire = $dive->isDiverRegistered($dvrId, $divId);
    $this->assertEquals(1, $isRegisteredAfterRetire[0]->par_cancelled);

    }

    
    public function testDiveAvailable()
    {
        
    }

    public function testDiveFinished()
    {
        
    }

    public function testDiveCancelled()
{
    
    $divId = DB::table('DIVES')->insertGetId([
        'DVR_LICENCE_MONITORS' => 'A-04-100003',
        'SHP_ID' => 1,
        'STA_ID' => 3, 
        'DLV_ID' => 5,
        'SIT_ID' => 6,
        'DIV_DATE' => '2024-04-10 09:00:00',
        'DIV_HEADCOUNT' => 8,
        'DIV_COMMENT' => 'Belle plongée annulée'
    ]);

    $dive = new Dive();
    $result = $dive->diveCancelled();

    $this->assertNotEmpty($result);
    $this->assertContains($divId,array_column($result, 'DIV_ID'));
}


    public function testDirectedPlannedDiveList()
    {
        
    }

    public function testCountParticipants()
    {
        
    }

    public function testGetDiversList()
{
    $divId = DB::table('DIVES')->insertGetId([
        'DVR_LICENCE_MONITORS' => 'A-04-100003',
        'SHP_ID' => 1,
        'STA_ID' => 1,
        'DLV_ID' => 5,
        'SIT_ID' => 6,
        'DIV_DATE' => '2024-04-10 09:00:00',
        'DIV_HEADCOUNT' => 8,
        'DIV_COMMENT' => 'Belle plongée matinale avec une bonne visibilité'
    ]);

    $dvrIds = [
        'A-04-100001',
        'A-04-100002',
        'A-04-100003',
        'A-04-100004',
        'A-04-100005',
    ];

    foreach ($dvrIds as $dvrId) {
        DB::table('PARTICIPATE')->insert([
            'DVR_LICENCE' => $dvrId,
            'DIV_ID' => $divId,
            'PAR_CANCELLED' => 0,
        ]);
    }

    $dive = new Dive();
    $diversList = $dive->getDiversList($divId);

    $this->assertCount(5, $diversList);

   
    $expectedNames = [
        'Passoni-Chevalier',
        'Delhoumi',
        'Jort',
        'Porcq',
        'Secouard',
    ];

    foreach ($diversList as $index => $diver) {
        $this->assertEquals($expectedNames[$index], $diver->DVR_NAME);
    }
   
}


    public function testSelectUsersDives()
    {
        
    }

    public function testGetParticipants()
    {
       
    }

    public function testShowDive()
    {
        
    }

    public function testShowSiteName()
    {
        
    }

    public function testShowShipName()
    {
        
    }

    public function testDiveCurrentUser()
    {
        
    }

    public function testEveryDivesTheDiverIsRegisteredIn()
    {
        
    }

    public function testIsDiveDirector()
    {
        
    }

    public function testGetHeadcount()
    {
        
    }

    public function testGetMaxDiveID()
    {
        
    }

    public function testCreateDive()
{
    $dive = new Dive();
    $result = $dive->createDive(
        1, 1, 1, 'A-04-100001', 'A-04-100002', 'A-04-100003', 5, '2024-01-01 12:00:00', 10, 'Commentaire de test'
    );

    $this->assertTrue($result);

    $this->assertDatabaseHas('DIVES', [
        'DIV_ID' => 1,
        'DVR_LICENCE_MONITORS' => 'A-04-100003',
        'SHP_ID' => 1,
        'DVR_LICENCE_DIRECTS' => 'A-04-100001',
        'DVR_LICENCE_DRIVES' => 'A-04-100002',
        'STA_ID' => 1,
        'DLV_ID' => 5,
        'SIT_ID' => 1,
        'DIV_DATE' => '2024-01-01 12:00:00',
        'DIV_HEADCOUNT' => 10,
        'DIV_COMMENT' => 'Commentaire de test',
    ]);
}


    public function testGetNbInDives()
    {
        
    }
}
