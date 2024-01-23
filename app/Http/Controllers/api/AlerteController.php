<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlerteResource;
use App\Models\Alerte;
use App\Models\User;
use App\Notifications\AlerteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AlerteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alertes = Alerte::query()->latest()->get();
        return response()->json(["data" => AlerteResource::collection($alertes), "message" => 'Alertes récupérées']);
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
            'alerte' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $alerte = Alerte::query()->create([
            'alerte_user' => auth()->user()->id,
            'alerte' => $request->get('alerte'),
            'vue' => 0,
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
        ]);

        $alerte->save();

        auth()->user()->notify(new AlerteNotification($alerte));
        $users = User::all();
        foreach ($users as $user) {
            Notification::send($user, new AlerteNotification($alerte));
        }

        return response()->json(["message" => 'Alerte créée.', "alerte" => new AlerteResource($alerte)], 201);
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

    }
}
