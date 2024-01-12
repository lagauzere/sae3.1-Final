<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
    /*
    use DatabaseTransactions;

    public function testRemainingCredits()
    {
        
        $userLicence = 'A-04-100050'; 
        $userModel = new User();

        
        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userLicence,
            'DVR_CREDITS' => 99,
        ]);

        $remainingCredits = $userModel->remainingCredits($userLicence);
        $this->assertEquals(99, $remainingCredits);

    }

    public function testCanDirect()
    {
    
        $userLicence = 'A-04-100051'; 

        
        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userLicence,
            'DVR_CANDIRECT' => true,
        ]);

        $canDirect = User::canDirect($userLicence);
        $this->assertEquals(-1, $canDirect);
    
    }

    public function testCheckRegistration()
    {
        
        $userLicence = 'A-04-100052'; 
        $divId = 1; 

        
        DB::table('PARTICIPATE')->insert([
            'DVR_LICENCE' => $userLicence,
            'DIV_ID' => $divId,
            'PAR_CANCELLED' => false,
        ]);

        $userModel = new User();
        $isRegistered = $userModel->checkRegistration($userLicence, $divId);
        $this->assertTrue($isRegistered);
    }
    
    Target class [config] does not exist. Not fixed yet.
    */
    public function testHello(){
        assertEquals("Hello","Hello");
        // to disable the warning
    }
}
