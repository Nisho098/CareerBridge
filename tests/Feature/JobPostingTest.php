<?php



namespace Tests\Feature;

use App\Models\User;
use App\Models\RecruiterProfile;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostInternshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function recruiter_can_post_an_internship_successfully()
    {
        // 1. Create a recruiter user
        $user = User::factory()->create([
            'role' => 'recruiter',
        ]);

        // 2. Create a recruiter profile
        $recruiterProfile = RecruiterProfile::create([
            'user_id' => $user->id,
            'company_name' => 'Test Company',
            'name' => 'Test Recruiter',
            'address' => 'Test Address',
            // Add other necessary fields if required
        ]);

        // 3. Acting as this recruiter
        $this->actingAs($user);

        // 4. Prepare form data
        $formData = [
            'title' => 'Software Developer Internship',
            'description' => 'Learn and grow as a Software Developer.',
            'salary' => 15000,
            'salary_type' => 'monthly',
            'benefits' => 'Certificate,Flexible Hours',
            'job_type' => 'internship',
            'industry' => 'Information Technology',
            'requirements' => 'Basic PHP, Laravel skills',
            'application_deadline' => now()->addDays(10)->toDateString(),
            'project_duration' => null,
            'payment_terms' => null,
        ];

        // 5. Post the request
        $response = $this->post(route('postinternships.store'), $formData);

        // 6. Check redirection and success message
        $response->assertRedirect(route('postinternships.tablecreate'));
        $response->assertSessionHas('success', 'Internship posted successfully!');

        // 7. Assert the database has the new job
        $this->assertDatabaseHas('jobs', [
            'title' => 'Software Developer Internship',
            'recruiter_id' => $recruiterProfile->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_requires_a_valid_job_type()
{
    $user = User::factory()->create(['role' => 'recruiter']);

    RecruiterProfile::create([
        'user_id' => $user->id,
        'company_name' => 'Test Company',
        'name' => 'Test Recruiter', // 👈 ADD THIS
        'address' => 'Test Address',
    ]);

    $this->actingAs($user);

    $formData = [
        'title' => 'Internship Title',
        'description' => 'Some description.',
        'salary_type' => 'weekly', // INVALID
        'job_type' => 'randomtype', // INVALID
    ];

    $response = $this->post(route('postinternships.store'), $formData);

    $response->assertSessionHasErrors(['salary_type', 'job_type']);
}

}

