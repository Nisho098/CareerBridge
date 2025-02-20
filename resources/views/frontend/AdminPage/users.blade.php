@extends('layouts.admin')



@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Manage Users</h2>
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border">
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ ucfirst($user->role) }}</td>
                <td class="px-4 py-2 flex space-x-2">
                  
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="delete-btn">Delete</button>
</form>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

