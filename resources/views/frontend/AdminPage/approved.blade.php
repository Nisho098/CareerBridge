@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('heading', 'Admin Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Pending Job Approvals</h2>
    <link rel="stylesheet" href="{{ asset('css/adminjobs.css') }}">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->isEmpty())
        <p>No pending job approvals.</p>
    @else
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Job Title</th>
                    <th class="px-4 py-2 border">Company</th>
                    <th class="px-4 py-2 border">Location</th>
                    <th class="px-4 py-2 border">Posted By</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr class="border">
                    <td class="px-4 py-2">{{ $job->title }}</td>
                    <td class="px-4 py-2">{{ $job->recruiterProfile->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $job->recruiterProfile->address ?? 'N/A' }}</td>

                    <td class="px-4 py-2">{{ $job->recruiterProfile->user->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <!-- Approve Job -->
                        <form action="{{ route('admin.approveJob', $job->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>

                        <!-- Delete Job -->
                        <form action="{{ route('admin.deleteJob', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

