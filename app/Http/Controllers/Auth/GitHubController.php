<!-- ?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GitHubController extends Controller
{
    public function redirectToGitHub()
    {
        // Just log the process before redirecting to GitHub
        Log::info('Redirecting to GitHub for authentication.');
    
        return Socialite::driver('github')->redirect();
    }
    

    public function handleGitHubCallback()
    {
        try {
            // Get the GitHub user data
            $githubUser = Socialite::driver('github')->user();
    
            Log::info('GitHub authentication successful.', ['github_user' => $githubUser]);
    
            // Check if user already exists or create a new one
            $user = User::updateOrCreate(
                ['github_id' => $githubUser->id],
                [
                    'name' => $githubUser->name,
                    'email' => $githubUser->email,
                    'github_username' => $githubUser->nickname,
                    'github_token' => $githubUser->token,
                    'github_avatar' => $githubUser->avatar,
                ]
            );
    
            // Fetch GitHub repositories
            $repos = Http::withToken($user->github_token)
                ->get('https://api.github.com/user/repos')
                ->json();
    
            // Log the repositories for debugging
            Log::info('Fetched GitHub repositories:', ['repos' => $repos]);
    
            // Store or update repositories for the user
            foreach ($repos as $repo) {
                $user->repositories()->updateOrCreate(
                    ['github_id' => $repo['id']],
                    [
                        'name' => $repo['name'],
                        'description' => $repo['description'],
                        'url' => $repo['html_url'],
                        'language' => $repo['language'],
                        'stars' => $repo['stargazers_count'],
                        'forks' => $repo['forks_count'],
                    ]
                );
            }
    
            // Log the successful login
            Log::info('Logging in user.', ['user_id' => $user->id]);
    
            // Log in the user and redirect to the profile page
            Auth::login($user);
    
            // Redirect the user to the profile page
            return redirect()->route('student.profile'); // Make sure this route is correct
    
        } catch (\Exception $e) {
            // Log the error and show an error message
            Log::error('GitHub authentication failed: ' . $e->getMessage());
    
            // Redirect with an error message
            return redirect()->route('dashboard')->with('error', 'GitHub authentication failed!');
        }
    }
    
} -->
