@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
<div class="dashboard-container">
    {{-- Welcome Header --}}
    <div class="dashboard-header">
        <div>
            <h1>Welcome, 
                {{ auth()->user()->name }} 👋</h1>
            
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stats-grid">
        {{-- Total Posts --}}
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <span class="stat-label">Total Posts</span>
                    <span class="stat-number">{{ $stats['totalPosts'] }}</span>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
        </div>

        {{-- Applications --}}
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <span class="stat-label">Applications</span>
                    <span class="stat-number">{{ $stats['totalApplications'] }}</span>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: {{ $stats['totalApplications'] > 0 ? 100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Accepted --}}
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <span class="stat-label">Accepted</span>
                    <span class="stat-number">{{ $stats['accepted'] }}</span>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: {{ $stats['totalApplications'] > 0 ? ($stats['accepted']/$stats['totalApplications'])*100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <span class="stat-label">Rejected</span>
                    <span class="stat-number">{{ $stats['rejected'] }}</span>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: {{ $stats['totalApplications'] > 0 ? ($stats['rejected']/$stats['totalApplications'])*100 : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    :root {
        --primary: #4CAF50;
        --secondary: #2196F3;
        --success: #4CAF50;
        --danger: #F44336;
        --warning: #FFC107;
        --info: #17A2B8;
        --dark: #2C3E50;
        --light: #f8f9fa;
        --gray: #6c757d;
        --white: #ffffff;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .dashboard-header .subtitle {
        color: var(--gray);
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.fa-briefcase { background: rgba(76, 175, 80, 0.1); color: var(--primary); }
    .stat-icon.fa-file-alt { background: rgba(33, 150, 243, 0.1); color: var(--secondary); }
    .stat-icon.fa-check-circle { background: rgba(23, 162, 184, 0.1); color: var(--info); }
    .stat-icon.fa-times-circle { background: rgba(244, 67, 54, 0.1); color: var(--danger); }

    .stat-progress {
        height: 6px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: var(--primary);
        border-radius: 3px;
        transition: width 0.6s ease;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endsection