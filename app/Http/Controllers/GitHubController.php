<!-- ?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class GitHubController extends Controller
{
    public function redirectToGitHub()
    {
        $scopes = config('services.github.scopes', []);
    
        return Socialite::driver('github')
            ->scopes($scopes) 
            ->redirect();
    }
    
    

    // Handle GitHub callback and store the authenticated user's data
    public function handleGitHubCallback()
    {
        try {
            // Get the authenticated user's GitHub data
            $githubUser = Socialite::driver('github')->user();

            // Find or create the user in the database
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

            // Log the user into the app
            Auth::login($user);

            // Fetch GitHub repositories using the user's token
            $repos = Http::withToken($user->github_token)
                ->get('https://api.github.com/user/repos')
                ->json();

            // Optionally, store repositories in the database
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

            // Redirect to the dashboard
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'GitHub authentication failed! ' . $e->getMessage());
        }
    }
} -->
