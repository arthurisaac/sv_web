@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    {{ __('Notifications') }}
                    <span id="notification-count" class="badge rounded-pill bg-danger">
                    {{ auth()->user()->unreadNotifications->count() }} Non lues
                </span>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Alerte</td>
                </tr>
                </thead>
                <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $loop->index+1  }}</td>
                        <td>{{ $notification->type }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
