<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;
    //  REGISTER TESTS
    public function test_register_page_loads_successfully()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name'                  => 'Mahmoud Hesham',
            'email'                 => 'mahmoud@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/profile');

        $this->assertDatabaseHas('users', [
            'name'  => 'Mahmoud Hesham',
            'email' => 'mahmoud@example.com',
        ]);

        $this->assertAuthenticated();
    }

    public function test_register_fails_when_name_is_missing()
    {
        $response = $this->post('/register', [
            'name'                  => '',
            'email'                 => 'mahmoud@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_register_fails_when_email_is_invalid()
    {
        $response = $this->post('/register', [
            'name'                  => 'Mahmoud Hesham',
            'email'                 => 'not-a-valid-email',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_register_fails_when_email_is_already_taken()
    {
        User::factory()->create(['email' => 'mahmoud@example.com']);

        $response = $this->post('/register', [
            'name'                  => 'Another User',
            'email'                 => 'mahmoud@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_register_fails_when_password_is_too_short()
    {
        $response = $this->post('/register', [
            'name'                  => 'Mahmoud Hesham',
            'email'                 => 'mahmoud@example.com',
            'password'              => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_register_fails_when_passwords_do_not_match()
    {
        $response = $this->post('/register', [
            'name'                  => 'Mahmoud Hesham',
            'email'                 => 'mahmoud@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'different999',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    //  LOGIN TESTS

    public function test_login_page_loads_successfully()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email'    => 'mahmoud@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'mahmoud@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/profile');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password()
    {
        User::factory()->create([
            'email'    => 'mahmoud@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'mahmoud@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_login_fails_with_non_existent_email()
    {
        $response = $this->post('/login', [
            'email'    => 'ghost@example.com',
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_login_fails_when_fields_are_empty()
    {
        $response = $this->post('/login', [
            'email'    => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    //  LOGOUT TEST

    public function test_user_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
