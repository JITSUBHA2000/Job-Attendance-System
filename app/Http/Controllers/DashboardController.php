<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek();
        $startOfMonth = $today->copy()->startOfMonth();

        if ($user->role_id === 1 || $user->role_id === 2) {
            // Admin Dashboard and manager
            $employeeIds = User::where('role_id', 3)->pluck('id');
            $totalEmployees = $employeeIds->count();

            $presentToday = Attendance::whereDate('date', $today)
                ->whereIn('user_id', $employeeIds)
                ->distinct('user_id')
                ->count('user_id');

            $dailyPercentage = $totalEmployees > 0
                ? round(($presentToday / $totalEmployees) * 100, 2)
                : 0;

            $presentThisWeek = Attendance::whereBetween('date', [$startOfWeek, $today])
                ->whereIn('user_id', $employeeIds)
                ->distinct('user_id')
                ->count('user_id');

            $weeklyPercentage = $totalEmployees > 0
                ? round(($presentThisWeek / $totalEmployees) * 100, 2)
                : 0;

            $presentThisMonth = Attendance::whereBetween('date', [$startOfMonth, $today])
                ->whereIn('user_id', $employeeIds)
                ->distinct('user_id')
                ->count('user_id');

            $monthlyPercentage = $totalEmployees > 0
                ? round(($presentThisMonth / $totalEmployees) * 100, 2)
                : 0;
        } else {
            // Employee Dashboard
            $dailyPercentage = Attendance::whereDate('date', $today)
                ->where('user_id', $user->id)
                ->exists() ? 100 : 0;

            $totalWeekDays = $today->diffInWeekdays($startOfWeek) + 1;
            $presentThisWeek = Attendance::whereBetween('date', [$startOfWeek, $today])
                ->where('user_id', $user->id)
                ->count();
            $weeklyPercentage = $totalWeekDays > 0
                ? round(($presentThisWeek / $totalWeekDays) * 100, 2)
                : 0;

            $totalMonthDays = $today->diffInWeekdays($startOfMonth) + 1;
            $presentThisMonth = Attendance::whereBetween('date', [$startOfMonth, $today])
                ->where('user_id', $user->id)
                ->count();
            $monthlyPercentage = $totalMonthDays > 0
                ? round(($presentThisMonth / $totalMonthDays) * 100, 2)
                : 0;
        }

        return view('dashboard', compact(
            'dailyPercentage',
            'weeklyPercentage',
            'monthlyPercentage'
        ));
    }
}
