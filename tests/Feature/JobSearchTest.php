<?php
namespace Tests\Feature;

use App\Models\Job;
use App\Models\RecruiterProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_jobs_based_on_search_query()
    {
        // 1. Create test data (same as before)
        $user = User::create([
            'name' => 'Test Recruiter',
            'email' => 'recruiter@test.com',
            'password' => bcrypt('password'),
            'role' => 'recruiter',
        ]);

        $recruiter = RecruiterProfile::create([
            'user_id' => $user->id,
            'name' => 'Test Recruiter Name',
            'company_name' => 'Test Company',
            'address' => 'Test Recruiter Address',
            'contact_number' => '1234567890',
            'company_description' => 'Test description',
        ]);

        Job::create([
            'title' => 'Software Developer',
            'description' => 'Test description',
            'industry' => 'Tech',
            'salary' => '50000',
            'status' => 'approved',
            'recruiter_id' => $recruiter->id,
            'job_type' => 'Full-time',
            'location' => 'Remote',
        ]);

        Job::create([
            'title' => 'Data Scientist',
            'description' => 'Test description',
            'industry' => 'Tech',
            'salary' => '60000',
            'status' => 'approved',
            'recruiter_id' => $recruiter->id,
            'job_type' => 'Full-time',
            'location' => 'Remote',
        ]);

        // 2. Test the search using the CORRECT route name
        $response = $this->get(route('jobs.search', ['query' => 'Software Developer']));
        
        // 3. Assertions
        $response->assertStatus(200);
        $response->assertSee('Software Developer');
        $response->assertDontSee('Data Scientist');
    }

    public function test_it_returns_empty_results_for_no_matching_query()
{
    // Create test data
    $user = User::create([
        'name' => 'Test Recruiter',
        'email' => 'recruiter2@test.com',
        'password' => bcrypt('password'),
        'role' => 'recruiter',
    ]);

    $recruiter = RecruiterProfile::create([
        'user_id' => $user->id,
        'name' => 'Test Recruiter Name 2',
        'company_name' => 'Test Company 2',
        'address' => 'Test Address',
        'contact_number' => '1234567890',
        'company_description' => 'Test description',
    ]);

    Job::create([
        'title' => 'Software Developer',
        'description' => 'Test description',
        'industry' => 'Tech',
        'salary' => '50000',
        'status' => 'approved',
        'recruiter_id' => $recruiter->id,
        'job_type' => 'Full-time',
        'location' => 'Remote',
    ]);

    // Test with non-matching query
    $response = $this->get(route('jobs.search', ['query' => 'NonExistingJob']));
    
    // Assertions
    $response->assertStatus(200);
    $response->assertSee('No jobs found matching your search criteria.');
}
}