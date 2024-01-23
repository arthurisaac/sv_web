<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AskForHelp;
use App\Models\User;
use App\Notifications\AskForHelpNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class AskForHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'recepteur' => 'required',
            'amount' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $ask = new AskForHelp([
            'emitteur' => auth()->user()->id,
            'recepteur' => $request->get("recepteur"),
            'amount' => $request->get("amount"),
        ]);
        $ask->save();

        $emetteur = User::query()->find($request->get('recepteur'));
        if ($emetteur) {
            $emetteur->notify(new AskForHelpNotification($emetteur, $request->get("amount")));
        }

        return response()->json(['message' => 'Demande envoyée.', 'emetteur' => $emetteur->nom], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
