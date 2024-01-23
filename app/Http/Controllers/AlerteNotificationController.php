<?php

namespace App\Http\Controllers;

use App\Models\AlerteNotification;
use Illuminate\Http\Request;

class AlerteNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;
        $unredNotifications = auth()->user()->unreadNotifications;
        return view('account.notifications.index', compact('notifications'));
    }
}
