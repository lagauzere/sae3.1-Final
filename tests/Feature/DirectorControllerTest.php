<?php

namespace Tests\Feature;

use App\Models\Dive;
use App\Models\User;
use App\Models\DeleteDive;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DirectorControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDirectedPlannedDiveList()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->get('/directedplanneddiveslist');
        
        // Assurer que la réponse est réussie
        $response->assertSuccessful();
    }

    public function testHandleFormChangeParticipationStateSubmission()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->post('/handle-form-change-participation-state', [
            'uid' => $user->id,
            'div_id' => 123,
            'wanted_state' => 1,
        ]);

        // Assurer que la vue retournée est 'directorEditDivers'
        $response->assertViewIs('directorEditDivers');
    }

    public function testHandleFormAddParticipationSubmission()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->post('/handle-form-add-participation', [
            'uid' => $user->id,
            'div_id' => 123,
        ]);

        // Assurer que la réponse est réussie
        $response->assertSuccessful();
    }

    public function testHandleFormRemoveParticipationSubmission()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->post('/handle-form-remove-participation', [
            'uid' => $user->id,
            'div_id' => 123,
        ]);

        // Assurer que la réponse est réussie
        $response->assertSuccessful();
    }

    public function testEditDivers()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->get('/edit-divers', ['div_id' => 123]);

        // Assurer que la vue retournée est 'directorEditDivers'
        $response->assertViewIs('directorEditDivers');
    }

    public function testDeleteDiver()
    {
        // Créer un utilisateur fictif
        $user = User::create([
            // Champs de l'utilisateur
        ]);

        // Simuler une session avec l'utilisateur
        $this->actingAs($user);

        // Appeler la route correspondante
        $response = $this->post('/delete-diver', ['div_id' => 123]);

        // Assurer que la redirection est correcte
        $response->assertRedirect('directedplanneddiveslist');
    }
}
