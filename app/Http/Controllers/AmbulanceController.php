<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Ambulance;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ambulances = Ambulance::query()->get();
        return view("admin.ambulance.index", compact("ambulances"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.ambulance.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Ambulance([
            'intitule' => $request->get("intitule"),
            'attribute' => $request->get("nom"),
        ]);
        $data->save();
        return redirect()->back()->with("success", "Enregistré avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Ambulance $ambulance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ambulance $ambulance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ambulance $ambulance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Ambulance::query()->find($id);
        if ($data) {
            $data->delete();
        }
        return redirect()->back()->with("success", "Enregistré avec succès");
    }

    public function affectAmbulance(Request $request) {
        $request->validate([
            'ambulance'=>'required',
            'alerte'=>'required',
        ]);
        $alerte = Alerte::query()->find($request->get("alerte"));
        $alerte->attribue_a = $request->get("ambulance");
        $alerte->traite = 1;
        $alerte->save();

        return redirect()->back()->with("success", "Affecté avec succès");
    }

    public function alerteTraite(Request $request) {
        $request->validate([
            'traite'=>'required',
            'alerte'=>'required',
        ]);
        $alerte = Alerte::query()->find($request->get("alerte"));
        $alerte->traite = $request->get("traite");
        $alerte->save();

        return redirect()->back()->with("success", "Status modififé");
    }
}
