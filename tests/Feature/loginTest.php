<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a student can log in with valid credentials.
     */
    public function test_student_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'student@edu.np',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $response = $this->post(route('loginUser'), [
            'email' => 'student@edu.np',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home.dindex'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that a recruiter can log in with valid credentials.
     */
    public function test_recruiter_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'recruiter@example.com',
            'password' => bcrypt('password'),
            'role' => 'recruiter',
        ]);

        $response = $this->post(route('loginUser'), [
            'email' => 'recruiter@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('recruiter.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that an admin can log in with valid credentials.
     */
    public function test_admin_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('loginUser'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that login fails with incorrect credentials.
     */
    public function test_login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'user@edu.np',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $response = $this->post(route('loginUser'), [
            'email' => 'user@edu.np',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('error');
        $this->assertGuest();
    }

    
    
    

    /**
     * Test that login fails when email is not found.
     */
    public function test_login_fails_if_email_not_found()
    {
        $response = $this->post(route('loginUser'), [
            'email' => 'nonexistent@edu.np',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('error');
        $this->assertGuest();
    }
}
