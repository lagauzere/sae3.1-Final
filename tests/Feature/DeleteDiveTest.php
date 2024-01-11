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

        DB::table('PARTICIPATE')->insert([
            ['DVR_LICENCE' => 'A-04-100001', 'DIV_ID' => $diveId, 'PAR_CANCELLED' => FALSE],
            ['DVR_LICENCE' => 'A-04-100002', 'DIV_ID' => $diveId, 'PAR_CANCELLED' => FALSE],
        ]);


        $deleteDiveModel = new DeleteDive();

        
        $result = $deleteDiveModel->deleteDive($diveId);

        
        $this->assertEquals(2, $result); 

        $this->assertDatabaseMissing('DIVES', ['DIV_ID' => $diveId]);
        $this->assertDatabaseMissing('PARTICIPATE', ['DIV_ID' => $diveId]);
    }
}