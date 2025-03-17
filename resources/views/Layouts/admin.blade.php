<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.users') }}">Users</a>
        <a href="{{ route('admin.pendingJobs') }}">Pending Job Posts</a>
        <a href="#">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>@yield('heading', 'Admin Dashboard')</h1>

        @yield('content') <!-- Content from child views -->
    </div>
</body>
</html>
