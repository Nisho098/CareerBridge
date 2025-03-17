<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('student_id', Auth::id())
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        Log::info("Notifications fetched for User ID: " . Auth::id(), $notifications->toArray());

        return view('frontend.StudentProfiles.notification', compact('notifications'));
    }

    

   
}

