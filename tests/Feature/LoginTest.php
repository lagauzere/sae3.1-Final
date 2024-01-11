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
        $userPassword = 'test_password';
        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userLicence,
            'DVR_PASSWORD' => $userPassword,
        ]);

        $selectedLicence = $loginModel->selectUser($userLicence, $userPassword);

        $this->assertEquals($userLicence, $selectedLicence);
    }

    public function testSelectName()
    {
        $loginModel = new Login();
        
        $userLicence = 'A-04-100051';
        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userLicence,
            'DVR_NAME' => 'TestUser',
        ]);

        $selectedName = $loginModel->selectName($userLicence);

        $this->assertEquals('TestUser', $selectedName[0]->DVR_NAME);
    }

    public function testGetUserLevel()
    {
        $loginModel = new Login();
        
        
        $userLicence = 'A-04-100052';
        $userLevel = 3; 

        DB::table('DIVERS')->insert([
            'DVR_LICENCE' => $userLicence,
            'DLV_ID' => $userLevel,
        ]);

        $selectedLevel = $loginModel->getUserLevel($userLicence);

        $this->assertEquals($userLevel, $selectedLevel);
    }
}
