<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\DeleteDive;

class DeleteDiveTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeleteDive()
    {
        $diveId = DB::table('DIVES')->insertGetId([
            'DIV_ID'=>60,
            'DVR_LICENCE_MONITORS' => 'A-04-100001',
            'SHP_ID' => 1,
            'DVR_LICENCE_DIRECTS' => 'A-04-100002',
            'DVR_LICENCE_DRIVES' => 'A-04-100003',
            'STA_ID' => 1,
            'DLV_ID' => 1,
            'SIT_ID' => 1,
            'DIV_DATE' => now(),
            'DIV_HEADCOUNT' => 10,
            'DIV_COMMENT' => 'Test Dive',
        ]);

        $this->assertDatabaseHas('DIVES', ['DIV_ID' => 60]);

        DB::table('PARTICIPATE')->insert([
            ['DVR_LICENCE' => 'A-04-100001', 'DIV_ID' => 60, 'PAR_CANCELLED' => 0],
            ['DVR_LICENCE' => 'A-04-100002', 'DIV_ID' => 60, 'PAR_CANCELLED' => 0],
        ]);


        $deleteDiveModel = new DeleteDive();

        
        $result = $deleteDiveModel->deleteDive(60);

        
        $this->assertEquals(1, $result); 

        $this->assertDatabaseMissing('DIVES', ['DIV_ID' => 60]);
        $this->assertDatabaseMissing('PARTICIPATE', ['DIV_ID' => 60]);
    }
}