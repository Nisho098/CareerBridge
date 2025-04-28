@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('heading', 'Admin Dashboard')

@section('content')
    <div class="card">
        <h2>Manage User</h2>
        <p>View, edit, or remove users.</p>
        <a href="{{ route('admin.users') }}" class="btn">View Users</a>
    </div>

    <div class="card">
        <h2>Approve Job Posts</h2>
        <p>Review and approve job postings before they go live.</p>
        <a href="{{ route('admin.pendingJobs') }}" class="btn">Review Posts</a>
    </div>
    <div class="card">
        <h2>Manage Job </h2>
        <p>View, edit, or remove Jobs.</p>
        <a href="{{ route('admin.pendingJobs') }}" class="btn">Review Posts</a>
    </div>

       
    
@endsection
