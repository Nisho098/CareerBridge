<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Admin Panel")</title>
    <style>
        :root {
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #1abc9c;
            --primary: #3498db;
            --primary-hover: #2980b9;
            --danger: #e74c3c;
            --danger-hover: #c0392b;
            --white: #ffffff;
            --light-gray: #ecf0f1;
            --dark-gray: #34495e;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--sidebar-bg);
            color: var(--white);
            height: 100vh;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 0 0.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--white);
        }

        .nav-menu {
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            color: var(--light-gray);
            text-decoration: none;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0;
            border-radius: 4px;
            transition: var(--transition);
        }

        .nav-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover, .nav-item.active {
            background-color: var(--sidebar-hover);
            color: var(--white);
            transform: translateX(5px);
        }

        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        .content {
            margin-left: 250px;
            padding: 2rem;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .content-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-gray);
        }

        /* Cards */
        .card {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-gray);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: var(--danger-hover);
        }

        /* Logout Button */
        .logout-btn {
            width: 100%;
            text-align: center;
            padding: 0.75rem;
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger);
            border-radius: 4px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background-color: var(--danger);
            color: var(--white);
        }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
                padding: 1.5rem 0.75rem;
            }

            .content {
                margin-left: 220px;
                width: calc(100% - 220px);
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: var(--transition);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                width: 100%;
            }

            .mobile-menu-btn {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--sidebar-bg);
                color: white;
                border: none;
                border-radius: 4px;
                padding: 0.5rem 0.75rem;
                font-size: 1.5rem;
                cursor: pointer;
            }
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Mobile Menu Button (hidden on desktop) -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-cog"></i> Admin Panel</h2>
        </div>

        <div class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item @if(request()->routeIs('admin.users')) active @endif">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('admin.pendingJobs') }}" class="nav-item @if(request()->routeIs('admin.pendingJobs')) active @endif">
                <i class="fas fa-clock"></i>
                <span>Pending Jobs</span>
            </a>
            <a href="{{ route('jobs.index') }}"class="nav-item @if(request()->routeIs('jobs.index')) active @endif">
                <i class="fas fa-job"></i>
                <span>Jobs</span>
            </a>
        </div>

         <!-- Logout Button in Footer -->
         <div class="logout">
            <a href="{{ route('home') }}" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="content-header">
            <h1>@yield('heading', 'Dashboard Overview')</h1>
            @yield('header-actions')
        </div>

        @yield('content') <!-- Content from child views -->

        @hasSection('footer')
            <footer class="mt-4 pt-3 border-top">
                @yield('footer')
            </footer>
        @endif
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            
            // Show/hide mobile menu button based on screen size
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    mobileMenuBtn.style.display = 'block';
                } else {
                    mobileMenuBtn.style.display = 'none';
                    sidebar.classList.remove('active');
                }
            }
            
            // Initial check
            checkScreenSize();
            
            // Check on resize
            window.addEventListener('resize', checkScreenSize);
            
            // Toggle sidebar
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>
</body>
</html>