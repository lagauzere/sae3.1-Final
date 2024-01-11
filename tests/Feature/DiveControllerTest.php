<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dive;

class DiveControllerTest extends TestCase
{
    use DatabaseTransactions;

    

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
        $response = $this->get('/creationDive');
        $response->assertSuccessful();
        $response->assertViewIs('creationDive');
    }

    

}
?>