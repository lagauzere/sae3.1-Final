<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
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
        // Créez un plongeur fictif dans la base de données
        $user = User::factory()->create();

        // Créez une plongée fictive dans la base de données
        $dive = Dive::factory()->create();

        // Effectuez une requête GET vers l'action editDivers avec les paramètres nécessaires
        $response = $this->get('/editdivers', ['div_id' => $dive->id]);

        // Vérifiez que la réponse est réussie
        $response->assertSuccessful();

        // Vérifiez que la vue est la vue attendue
        $response->assertViewIs('directorEditDivers');

        // Vérifiez que les données nécessaires sont présentes dans la vue
        $response->assertViewHas('div_id', $dive->id);
        $response->assertViewHas('participants');
    }

    public function testDeleteDiver()
    {
        // Créez un plongeur fictif dans la base de données
        $user = User::factory()->create();

        // Créez une plongée fictive dans la base de données
        $dive = Dive::factory()->create();

        // Effectuez une requête POST vers l'action deleteDiver avec les paramètres nécessaires
        $response = $this->post('/deletediver', ['div_id' => $dive->id]);

        // Vérifiez que la redirection a été effectuée avec succès
        $response->assertRedirect('directedplanneddiveslist');

        // Vérifiez que la plongée a été supprimée de la base de données
        $this->assertDatabaseMissing('dives', ['id' => $dive->id]);
    }

}

?>