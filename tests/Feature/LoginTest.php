<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Login;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testSelectUser()
    {
        $loginModel = new Login();
        
        $userLicence = 'A-04-100050';
        $userPassword = 'password123';
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

        $selectedLicence = $loginModel->selectUser($userLicence, $userPassword);

        $this->assertEquals($userLicence, $selectedLicence);
    }

    public function testSelectName()
    {
        $loginModel = new Login();
        
        $userLicence = 'A-04-100050';
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

        $selectedName = $loginModel->selectName($userLicence);

        $this->assertEquals('DiverName', $selectedName[0]->DVR_NAME);
    }

    public function testGetUserLevel()
    {
        $loginModel = new Login();
        
        $userLevel=5;
        $userLicence = 'A-04-100050';
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

        $selectedLevel = $loginModel->getUserLevel($userLicence);
        $actualLevel = count($selectedLevel) > 0 ? $selectedLevel[0]->DLV_ID : null;
        $this->assertEquals($userLevel, $actualLevel);
    }
}
