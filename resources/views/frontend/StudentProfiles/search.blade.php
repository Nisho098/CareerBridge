<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search Results</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .job-search-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            padding: 10px 15px;
            background-color: rgb(65, 110, 47);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: rgb(53, 99, 33);
        }
        .job-listing {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .job-item {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .job-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .job-item h3 {
            font-size: 24px;
            color: rgb(63, 128, 46);
            margin-bottom: 10px;
        }
        .job-item p {
            font-size: 16px;
            color: #495057;
            margin: 5px 0;
        }
        .apply-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .apply-btn:hover {
            background-color: #218838;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }
        .pagination a {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        .pagination .disabled {
            background-color: #6c757d;
            pointer-events: none;
        }
        .no-results {
            text-align: center;
            font-size: 18px;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="job-search-container">
        <h1>Job Search Results</h1>

        {{-- Error message if user not logged in --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Search bar --}}
        <form action="{{ route('jobs.search') }}" method="GET">
            <input type="text" name="query" placeholder="Search by title, industry, or location..." value="{{ request()->query('query') }}">
            <button type="submit">Search</button>
        </form>

        {{-- No jobs found --}}
        @if($jobs->isEmpty())
            <p class="no-results">No jobs found matching your search criteria.</p>
        @else
            {{-- Job listings --}}
            <div class="job-listing">
                @foreach($jobs as $job)
                    <div class="job-item">
                        <h3>{{ $job->title }}</h3>
                        <p><strong>Company:</strong> {{ $job->industry }}</p>
                        <p><strong>Type:</strong> {{ $job->job_type }}</p>
                        <p><strong>Description:</strong> {{ $job->description }}</p>
                        <p><strong>Location:</strong> {{ $job->recruiter->address ?? 'N/A' }}</p>
                        <p><strong>Requirements:</strong> {{ $job->requirements }}</p>

                        @auth
    <a href="{{ route('jobs.apply', ['id' => $job->id]) }}" class="apply-btn">Apply Now</a>
@else
    <a href="{{ route('loginUser') }}?redirect={{ route('jobs.apply', ['id' => $job->id]) }}" class="apply-btn">
        Apply Now
    </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Pagination --}}
        <div class="pagination">
            {{ $jobs->links() }}
        </div>
    </div>
</body>
</html>
