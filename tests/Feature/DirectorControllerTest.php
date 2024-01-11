<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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


}

?>