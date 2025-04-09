<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Notifications\AttendanceAlertNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $today = now();

        $allAttendance = Attendance::where('user_id', $userId)
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get()
            ->keyBy('date'); 

        return view('employee.add_attendance', ['allAttendance' => $allAttendance]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = Employee::with('schedule')->where('user_id', Auth::id())->first();
        $scheduledIn = $employee->schedule->time_in;
        $scheduledOut = $employee->schedule->time_out;

        // Default status
        $status = 'present';

        $request->validate([
            'date' => 'required|date',
        ]);
        $checkInTime = $request->check_in_time ? date('H:i:s', strtotime($request->check_in_time)) : null;
        $checkOutTime = $request->check_out_time ? date('H:i:s', strtotime($request->check_out_time)) : null;
        if ($checkInTime && strtotime($checkInTime) > strtotime($scheduledIn)) {
            $status = 'late';
            Auth::user()->notify(
                new AttendanceAlertNotification('You have checked in late on ' . $request->date)
            );
        }

        if ($checkOutTime && strtotime($checkOutTime) < strtotime($scheduledOut)) {
            $status = 'early_checkout';
            Auth::user()->notify(
                new AttendanceAlertNotification('You have checked out early on ' . $request->date)
            );
        }

        if (empty($request->attendance_id)) {
            $createAttendance = Attendance::create([
                'user_id'       => Auth::id(),
                'date'          => $request->date,
                'check_in_time' => $checkInTime !== '00:00:00' ? $checkInTime : null,
                'check_out_time'=> $checkOutTime !== '00:00:00' ? $checkOutTime : null,
                'status'        => $status, 
            ]);
            if($createAttendance){
                return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Attendance submitted successfully!']);
            }
        }else{
            $attendance = Attendance::find($request->attendance_id);

            $updatedCheckInTime = $checkInTime !== '00:00:00' && $checkInTime !== null ? $checkInTime : $attendance->check_in_time;
            $updatedCheckOutTime = $checkOutTime !== '00:00:00' && $checkOutTime !== null ? $checkOutTime : $attendance->check_out_time;
    
            $status = 'present';
            if ($updatedCheckInTime && strtotime($updatedCheckInTime) > strtotime($scheduledIn)) {
                $status = 'late';
                Auth::user()->notify(
                    new AttendanceAlertNotification('You have checked in late on ' . $request->date)
                );
            }
    
            if ($updatedCheckOutTime && strtotime($updatedCheckOutTime) < strtotime($scheduledOut)) {
                $status = 'early_checkout';
                Auth::user()->notify(
                    new AttendanceAlertNotification('You have checked out early on ' . $request->date)
                );
            }

            $attendance->update([
                'check_in_time' => $updatedCheckInTime,
                'check_out_time'=> $updatedCheckOutTime,
                'status'        => $status,
            ]);
    
            return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Attendance updated successfully.',]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEmployeeSheetReport(){

        $employees = Employee::with(['user:id,name', 'position:id,name', 'attendances:id,user_id,date,check_in_time,check_out_time'])
                        ->whereHas('user', function ($query) {
                            $query->where('role_id', 3);
                        })->get();

        // dd($employees->toArray());
        $today = today();
        $dates = [];
        for ($i = 1; $i <= $today->daysInMonth; $i++) {
            $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
        }

        return view('admin.employee_sheet_report', compact('employees', 'dates'));
    }
}
