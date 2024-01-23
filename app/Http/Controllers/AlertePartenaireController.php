<?php

namespace App\Http\Controllers;

use App\Models\AlertePartenaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AlertePartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partenaires = User::query()->where("partenaire", "1")->get();
        return view("admin.partenaires.index", compact("partenaires"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.partenaires.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'partenaire' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:' . User::class,
            'email' => 'string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $uniq = substr(str_shuffle('0123456789'), 0, 6);

        $users = User::query()->where("uniq", $uniq)->first();
        if (!$users) {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'name' => $request->nom . " " . $request->prenom,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'password' => Hash::make(env('DEFAULT_PASSWORD', 'SAUVIEALERTEDEFAULTKEY')),
                'uniq' => $uniq,
                'partenaire' => $request->partenaire,
            ]);
            $user->save();
        }

        return redirect()->back()->with("success", "Enregistré");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($d)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $partnaire = \App\Models\User::query()->find($id);
        if ($partnaire) {
            $partnaire->delete();
        }

        return redirect()->back()->with("success", "Supprimé avec succès");
    }
}
