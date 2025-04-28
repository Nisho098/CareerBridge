@extends('frontend.StudentProfiles.dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('css/notification.css') }}">

<h2 class="text-2xl font-semibold mb-4 text-gray-800">Notifications</h2>

<div id="notification-container">
    @forelse($notifications as $notification)
    <div class="notification-card bg-white shadow-lg rounded-lg p-4 mb-4 border-l-4 transition-all duration-300 
        {{ $notification->type == 'accepted' ? 'border-green-500' : 'border-red-500' }}">

        <div class="flex items-center">
            <div class="icon-container p-2 rounded-full 
                {{ $notification->type == 'accepted' ? 'bg-green-100' : 'bg-red-100' }}">
                <i class="uil {{ $notification->type == 'accepted' ? 'uil-check-circle text-green-500' : 'uil-times-circle text-red-500' }} text-2xl"></i>
            </div>

            <div class="ml-4">
                <p class="text-gray-700 font-medium">
                    {{ $notification->message }}
                </p>
               
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-500 text-center">No notifications available.</p>
    @endforelse
</div>

@endsection
