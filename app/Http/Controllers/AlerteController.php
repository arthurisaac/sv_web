<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Ambulance;
use Illuminate\Http\Request;

class AlerteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alertes = Alerte::with('alerteUser')->get();
        return view('admin.alertes.index', compact('alertes'));
    }

    public function customAlertes(Request $request)
    {
        $date = $request->get('date');
        if ($date) {
            $alertes = Alerte::query()->latest()
                ->whereDate('created_at', date($date))
                ->count();
        } else {
            $alertes = Alerte::query()->latest()->count();
        }

        return response()->json(['total' => $alertes, 'date' => $date]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // $alerte = Alerte::query()->findOrFail($id)->first();
        // auth()->user()->notify(new AlerteNotification($alerte));
        //Notification::send(auth()->user(), new AlerteNotification($alerte));
        //echo "Notification envoyée";

        $ambulances = Ambulance::query()->get();
        $alerte = Alerte::query()->findOrFail($id);
        $alerte->vue = 1;
        $alerte->save();

        return view('admin.alertes.show', compact('alerte', 'ambulances'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
