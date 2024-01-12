<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Login;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test the user login process with valid credentials.
     *
     * @return void
     */
    public function testUserLoginWithValidCredentials()
    {
        $response = $this->post('/', [
            'licence' => 'A-04-100003', 
            'password' => 'password345',
        ]);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('erreurCode', 0);
    }

    /**
     * Test the user login process with invalid credentials.
     *
     * @return void
     */
    public function testUserLoginWithInvalidCredentials()
    {
        $response = $this->post('/', [
            'licence' => 'invalid_licence', // Use an invalid licence
            'password' => 'invalid_password', // Use an invalid password
        ]);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('erreurCode', -1);
    }

    /**
     * Test the user logout process.
     *
     * @return void
     */
    public function testUserLogout()
    {
        // Assuming that there is a user logged in, you may need to modify this based on your authentication logic
        session(['userID' => 1, 'userName' => 'John Doe', 'userLevel' => 'admin']);

        $response = $this->post('/disconnect');

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
