@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            Employee Attendance Sheet Report
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-md table-hover" id="printTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            @foreach ($dates as $date)
                                <th>{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->user['name'] ?? 'N/A' }}</td>
                                <td>{{ $employee->position['name'] ?? 'N/A' }}</td>

                                @foreach ($dates as $date)
                                    @php
                                        $attendance = collect($employee->attendances)->firstWhere('date', $date);
                                    @endphp
                                    <td class="text-center">
                                        @if ($attendance && $attendance['check_in_time'] && $attendance['check_out_time'])
                                            <i class="fa fa-check text-success" title="Check-in: {{ $attendance['check_in_time'] }} | Check-out: {{ $attendance['check_out_time'] }}"></i>
                                        @else
                                            <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>

            </div>
        </div>
    </div>
@endsection
