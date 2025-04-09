<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')->get();


        // echo "<pre>";print_r($notifications);die;

        return view('admin.notification_list', compact('notifications'));
    }
}
