<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managerList = Manager::with('user') ->whereHas('user', function ($query) {
            $query->where('role_id', 2);
        })->get();
        // echo "<pre>";print_r($managerList);die;
        return view('admin.managerlist', compact('managerList'));
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
            'join_date'    => 'required|date',
            'status'       => 'in:Active,Inactive'
        ]);
    
        $insertManager = User::create([
            'name'     => $validated['name'],
            'role_id'  => '2',
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        if($insertManager){
            Manager::create([
                'user_id'     => $insertManager->id,
                'join_date'   => $validated['join_date'],
                'status'      => $validated['status'] ?? 'Active',
            ]);
        
            return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Manager created successfully!',]);
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
        $manager = Manager::findOrFail($id);
        $user = $manager->user;

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'join_date'         => 'required|date',
            'status'            => 'required|in:Active,Inactive',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $manager->update([
            'join_date'     => $validated['join_date'],
            'status'        => $validated['status'],
        ]);

        return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Manager updated successfully.',]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manager = Manager::findOrFail($id);
        $user = $manager->user;
        $manager->delete();
    
        if ($user) {
            $user->delete();
        }
    
        return redirect()->back()->with('flash_message', ['title' => 'Success!','message' => 'Manager deleted successfully.',]);
    }
}
