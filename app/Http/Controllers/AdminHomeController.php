<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function home(Request $request) {
        $totalUserSV = User::query()->count();
        $totalRecharge = Transaction::query()->whereNull("partenaire")->sum('amount');
        $totalUserKYCSV = User::query()->where("verified", "-1")->count();
        $totalUserSauvie = User::query()->where("verified", "-1")->count();
        return view('admin.index', compact('totalUserSV', 'totalRecharge', 'totalUserKYCSV', 'totalUserSauvie'));
    }
}
