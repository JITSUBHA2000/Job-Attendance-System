@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">📩 Your Notifications</h4>
    <div class="list-group">
        @forelse($notifications as $notification)
            @php
                $data = json_decode($notification->data, true);
                $user = \App\Models\User::find($notification->notifiable_id);
                $name = $user ? $user->name : 'Unknown';
                $message = $data['message'] ?? '';
            @endphp
            <li class="list-group-item">
                <strong>{{ $name }}</strong> {{ $message }}
            </li>
        @empty
            <div class="alert alert-info">No notifications yet.</div>
        @endforelse
    </div>
</div>
@endsection
