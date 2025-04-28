<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Auth;
use App\Models\GitHubRepository;
use Github\Client as GitHubClient;
use Illuminate\Support\Facades\Log;
use Exception;

class GitHubController extends Controller
{
    
    public function redirectToGitHub()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return Socialite::driver('github')->redirect();
    }

  
    public function handleGitHubCallback()
{
    try {
        $githubUser = Socialite::driver('github')->user();
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

       
        $user->github_id = $githubUser->getId();
        $user->github_token = $githubUser->token;
        $user->avatar = $githubUser->getAvatar();
        $user->save();  

        
        $client = new GitHubClient();
        $client->authenticate($githubUser->token, null, GitHubClient::AUTH_ACCESS_TOKEN);

        $repositories = $client->api('user')->repositories($githubUser->getNickname());

       
        foreach ($repositories as $repo) {
           
            $readme = null;
            try {
                $readme = $client->api('repo')->contents()->readme($githubUser->getNickname(), $repo['name']);
            } catch (\Exception $e) {
                
            }

            GitHubRepository::updateOrCreate(
                ['github_id' => $repo['id']], 
                [
                    'user_id' => $user->id,
                    'github_name' => $repo['name'],
                    'description' => $repo['description'] ?? 'No description available',
                    'url' => $repo['html_url'],
                    'is_public' => !$repo['private'], 
                    'readme' => $readme['content'] ?? null, 
                ]
            );
        }

        return redirect()->route('studentProfile.create')->with('success', 'GitHub linked and repositories saved!');
    } catch (InvalidStateException $e) {
        Log::error('InvalidStateException: ' . $e->getMessage());
        return redirect()->route('login')->with('error', 'Invalid state, please try again.');
    } catch (Exception $e) {
        Log::error('Exception: ' . $e->getMessage());
        return redirect()->route('studentProfile.create')->with('error', 'An error occurred while processing your request.');
    }
}

}