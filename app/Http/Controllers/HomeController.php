<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\AlerteMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $now = Carbon::now();
        $date = $request->get('date');
        if ($date) {
            $alertes = Alerte::query()->latest()
                ->whereDate("created_at", date($date))
                ->get();
        } else {
            $alertes = Alerte::query()->latest()->get();
        }
        $users = User::all();
        $messages = AlerteMessage::query()->limit(10)->get();
        return view('home', compact('alertes', 'users', 'messages', 'date', 'now'));
    }
}
