@extends('layouts.app')

@section('breadcrumb')
<div class="col-sm-6 text-left">
    <h4 class="page-title">Employee Attendance</h4>
</div>
@endsection

@section('content')
@include('includes.flash')

<div class="container mt-4">
    <h3 class="text-center mb-4">My Attendance - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>

    <div class="card">
        <div class="card-body">
            <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
                <input type="hidden" name="check_in_time" id="check_in_time">
                <input type="hidden" name="check_out_time" id="check_out_time">

                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check In Time</th>
                                <th>Check Out</th>
                                <th>Check Out Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $today = now();
                                $daysInMonth = $today->daysInMonth;
                                $year = $today->year;
                                $month = $today->month;
                            @endphp

                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                @php
                                    $date = \Carbon\Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
                                    $attendance = $allAttendance[$date] ?? null;
                                    $isToday = $date === now()->format('Y-m-d');
                                @endphp
                                <tr>
                                    <td>{{ $date }}</td>

                                    <td>
                                        <input type="checkbox" class="check-in" data-row="{{ $i }}" {{ $isToday ? '' : 'disabled' }} {{ $attendance && $attendance->check_in_time ? 'checked' : '' }}>
                                    </td>
                                    <td id="checkin-time-{{ $i }}"> 
                                        {{ $attendance && $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i:s A') : '--' }} 
                                    </td>

                                    <td>
                                        <input type="checkbox" class="check-out" data-row="{{ $i }}" {{ $isToday ? '' : 'disabled' }} {{ $attendance && $attendance->check_out_time ? 'checked' : '' }}>
                                    </td>
                                    <td id="checkout-time-{{ $i }}">
                                        {{ $attendance && $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('h:i:s A') : '--' }}
                                    </td>

                                    <td>
                                        @if ($isToday)
                                            @if ($attendance)
                                                <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                                                <button id="submit-btn-{{ $i }}" type="submit" class="btn btn-warning btn-sm">Update Attendance</button>
                                            @else
                                                <button id="submit-btn-{{ $i }}" type="submit" class="btn btn-sm btn-success">Submit Attendance</button>
                                            @endif
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Submit Attendance</button>
                                        @endif
                                    </td>
                                    

                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const todayIndex = new Date().getDate();
    const checkInCheckbox = document.querySelector(`.check-in[data-row="${todayIndex}"]`);
    const checkOutCheckbox = document.querySelector(`.check-out[data-row="${todayIndex}"]`);
    const submitBtn = document.querySelector(`#submit-btn-${todayIndex}`);
    const checkInTimeField = document.getElementById('check_in_time');
    const checkOutTimeField = document.getElementById('check_out_time');

    function updateButtonState() {
        if (checkInCheckbox.checked || checkOutCheckbox.checked) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    checkInCheckbox.addEventListener('change', function () {
        const checkInTime = document.getElementById(`checkin-time-${todayIndex}`);
        const now = new Date().toLocaleTimeString();
        if (this.checked) {
            checkInTime.innerText = now;
            checkInTimeField.value = now;
        } else {
            checkInTime.innerText = '--';
            checkInTimeField.value = '';
        }
        updateButtonState();
    });

    checkOutCheckbox.addEventListener('change', function () {
        const checkOutTime = document.getElementById(`checkout-time-${todayIndex}`);
        const now = new Date().toLocaleTimeString();
        if (this.checked) {
            checkOutTime.innerText = now;
            checkOutTimeField.value = now;
        } else {
            checkOutTime.innerText = '--';
            checkOutTimeField.value = '';
        }
        updateButtonState();
    });

    // Initial state
    updateButtonState();
});
</script>

@endsection
