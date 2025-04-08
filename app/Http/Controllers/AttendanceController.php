<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
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
        $request->validate([
            'date' => 'required|date',
        ]);
        $checkInTime = $request->check_in_time ? date('H:i:s', strtotime($request->check_in_time)) : null;
        $checkOutTime = $request->check_out_time ? date('H:i:s', strtotime($request->check_out_time)) : null;

        if (empty($request->attendance_id)) {
            $createAttendance = Attendance::create([
                'user_id'       => Auth::id(),
                'date'          => $request->date,
                'check_in_time' => $checkInTime !== '00:00:00' ? $checkInTime : null,
                'check_out_time'=> $checkOutTime !== '00:00:00' ? $checkOutTime : null,
                'status'        => 'Present', 
            ]);
            if($createAttendance){
                return redirect()->back()->with('success', 'Attendance submitted successfully!');
            }
        }else{
            $attendance = Attendance::find($request->attendance_id);

            $updatedCheckInTime = $checkInTime !== '00:00:00' && $checkInTime !== null ? $checkInTime : $attendance->check_in_time;
            $updatedCheckOutTime = $checkOutTime !== '00:00:00' && $checkOutTime !== null ? $checkOutTime : $attendance->check_out_time;
    
            $attendance->update([
                'check_in_time' => $updatedCheckInTime,
                'check_out_time'=> $updatedCheckOutTime,
            ]);
    
            return redirect()->back()->with('success', 'Attendance updated successfully.');
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
