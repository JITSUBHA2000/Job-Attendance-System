<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $schedules = Schedule::all();
        $employees = Employee::with(['user', 'position', 'schedule'])->get();

        return view('admin.employeeslist', compact('positions', 'schedules', 'employees'));
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
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'position_id'  => 'required|exists:positions,id',
            'schedule_id'  => 'required|exists:schedules,id',
            'join_date'    => 'required|date',
            'status'       => 'in:Active,Inactive'
        ]);
    
        $insertEmployee = User::create([
            'name'     => $validated['name'],
            'role_id'  => '3',
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        if($insertEmployee){

        }
        Employee::create([
            'user_id'     => $insertEmployee->id,
            'position_id' => $validated['position_id'],
            'schedule_id' => $validated['schedule_id'],
            'join_date'   => $validated['join_date'],
            'status'      => $validated['status'] ?? 'Active',
        ]);
    
        return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Employee created successfully!',]);
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
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'position_id'       => 'required|exists:positions,id',
            'schedule_id'       => 'required|exists:schedules,id',
            'join_date'         => 'required|date',
            'status'            => 'required|in:Active,Inactive',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $employee->update([
            'position_id'   => $validated['position_id'],
            'schedule_id'   => $validated['schedule_id'],
            'join_date'     => $validated['join_date'],
            'status'        => $validated['status'],
        ]);

        return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Employee updated successfully.',]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;
        $employee->delete();
    
        if ($user) {
            $user->delete();
        }
    
        return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Employee deleted successfully.',]);
    }
}
