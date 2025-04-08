<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allSchedule = Schedule::all();
        return view('admin.schedule',['allSchedule' => $allSchedule]);
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
        $validatedData = $request->validate([
            'slug' => 'required|string|max:255|unique:schedules,slug',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        // echo $validatedData['time_in'];die;

        $createSchedule = Schedule::create([
            'slug'      => $validatedData['slug'],
            'time_in'   => $validatedData['time_in'],
            'time_out'  => $validatedData['time_out'],
            'createdBy' => Auth::id()
        ]);
        if($createSchedule){
            return redirect()->route('schedule.index')->with('flash_message', ['title' => 'Success!','message' => 'Schedule created successfully.','level' => 'success',]);
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
        $validatedData = $request->validate([
            'slug' => 'required|string|max:255|unique:schedules,slug,' . $id,
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i|after:time_in',
        ]);
        $schedule = Schedule::findOrFail($id);
        $updateSchedule = $schedule->update([
            'slug'      => $validatedData['slug'],
            'time_in'   => $validatedData['time_in'],
            'time_out'  => $validatedData['time_out'],
            'updatedBy' => Auth::id()
        ]);
        if($updateSchedule){
            return redirect()->route('schedule.index')->with('flash_message', ['title' => 'Success!','message' => 'Schedule updated successfully.',]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedule.index')->with('flash_message', ['title' => 'Success!','message' => 'Schedule deleted successfully.',]);
    }
}
