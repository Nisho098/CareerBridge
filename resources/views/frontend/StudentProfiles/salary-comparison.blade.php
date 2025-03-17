@extends('frontend.StudentProfiles.dashboard')

@section('content')

<a href="{{ route('freelancing.index') }}" class="back-btn">Back</a>

<div class="container">
    <h1 class="title">Freelancing Salary & Benefits Comparison</h1>

  

    <section>
        <h3 class="subtitle">Freelancing Salary Data</h3>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Salary Type</th>
                    <th onclick="sortTable(4)">Average Salary</th>
                    <th>Project Duration</th>
                    <th>Payment Terms</th>
                    <th>Benefits</th>
                </tr>
            </thead>
            <tbody>
                @foreach($freelancingSalaries as $salary)
                <tr>
                    <td>{{ e(ucfirst($salary['title'])) }}</td>
                    <td>{{ e($salary['company_name']) }}</td>
                    <td>{{ e($salary['industry'] ?? 'N/A') }}</td>
                    <td>{{ e(ucfirst($salary['salary_type'])) }}</td>
                    <td>Rs. {{ number_format($salary['avg_salary'], 2, '.', ',') }}</td>
                    <td>{{ $salary['project_duration'] ?? 'Not Set' }}</td>
                    <td>{{ $salary['payment_terms'] ?? 'Not Set' }}</td>
                    <td>
                        @php
                            $benefits = is_string($salary['benefits']) ? json_decode($salary['benefits'], true) : $salary['benefits'];
                        @endphp
                        @if(is_array($benefits) && !empty($benefits))
                            <ul>
                                @foreach($benefits as $benefit)
                                    <li>{{ e($benefit) }}</li>
                                @endforeach
                            </ul>
                        @else
                            No benefits provided
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>

<script>
function sortTable(columnIndex) {
    const table = document.querySelector('.custom-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const aValue = parseFloat(a.cells[columnIndex].textContent.replace(/[^0-9.]/g, ''));
        const bValue = parseFloat(b.cells[columnIndex].textContent.replace(/[^0-9.]/g, ''));

        return bValue - aValue; // For descending order (high to low)
    });

    // Clear the table and append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}
</script>

@endsection

<style>
/* General Page Styling */
.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background: #f4f4f4;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Titles */
.title {
    text-align: center;
    color: #333;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.subtitle {
    font-size: 18px;
    color: #555;
    margin-bottom: 15px;
}

/* Back Button */
.back-btn {
    display: inline-block;
    padding: 12px 20px;
    font-size: 1rem;
    color: white;
    background-color: rgb(116, 150, 101);
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-bottom: 20px;
}

.back-btn:hover {
    background-color: rgb(98, 184, 61);
}

/* Sorting Options */
.sort-options {
    margin-bottom: 20px;
}

.sort-options a {
    display: inline-block;
    padding: 8px 12px;
    margin-right: 10px;
    font-size: 0.9rem;
    color: white;
    background-color: rgb(116, 150, 101);
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.sort-options a:hover {
    background-color: rgb(98, 184, 61);
}

/* Table Styling */
.custom-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 5px;
    overflow: hidden;
}

.custom-table th, .custom-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.custom-table th {
    background: rgb(116, 150, 101);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.custom-table th:hover {
    background: rgb(98, 184, 61);
}

.custom-table tr:nth-child(even) {
    background: #f9f9f9;
}

.custom-table tr:hover {
    background: #e3f2e1;
    transition: background 0.2s ease-in-out;
}

/* Benefits List Styling */
.custom-table ul {
    margin: 0;
    padding-left: 20px;
}

.custom-table ul li {
    list-style-type: disc;
    margin-bottom: 5px;
}
</style>