@extends('layouts.app')

@section('breadcrumb')
<div class="col-sm-6 text-left">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Welcome to Simple Attendance Management System</li>
    </ol>
</div>
@endsection

@section('content')
<!-- NEW Attendance Summary Cards -->
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Daily Attendance</h5>
                <h2 class="text-white">{{ $dailyPercentage }}%</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Weekly Attendance</h5>
                <h2 class="text-white">{{ $weeklyPercentage }}%</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Monthly Attendance</h5>
                <h2 class="text-white">{{ $monthlyPercentage }}%</h2>
            </div>
        </div>
    </div>
</div>

<!-- Group-wise Chart -->
<!-- <div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Group-wise Attendance</h5>
            </div>
            <div class="card-body">
                <canvas id="groupChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div> -->
@endsection

@section('script')
<!-- Chart JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('groupChart').getContext('2d');
    const groupChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['HR', 'Development', 'Marketing', 'Support'],
            datasets: [{
                label: 'Attendance (%)',
                data: [90, 85, 78, 88],
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script> -->

<!-- Existing scripts -->
<script src="{{ URL::asset('plugins/chartist/js/chartist.min.js') }}"></script>
<script src="{{ URL::asset('plugins/chartist/js/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ URL::asset('plugins/peity-chart/jquery.peity.min.js') }}"></script>
<script src="{{ URL::asset('assets/pages/dashboard.js') }}"></script>
@endsection
