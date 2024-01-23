<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlerteSanteStructure extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structures = \App\Models\AlerteSanteStructure::query()
            ->with("SanteCategories")
            ->get();
            return response()->json(["data" => $structures]);
        //return new ApiResource($structures);
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
            'structure' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $structure = \App\Models\AlerteSanteStructure::query()->find($request->structure);
        if ($structure) {
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');
            $position = "https://maps.google.com/maps?z=12&t=m&q=$latitude,$longitude";

            $nom = auth()->user()->nom;
            $prenom = auth()->user()->prenom;
            $sms = "Alerte! $nom $prenom est dans une situation d'urgence. Sa dernière position ici : $position";

            $data = array(
                'position' => $position,
                'telephone' => $structure->contact,
                'message' => $sms
            );

            $url = 'https://sauvie.aino-digital.com/view/send_sms.php';
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($ch);
            //echo $response;

            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);

            return response()->json(['message' => 'SMS envoyé.', 'sms' => $sms]);
        }

        return response()->json(['message' => 'Structure non trouve.',]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $structure = \App\Models\AlerteSanteStructure::query()
            ->with('SanteCategories')
            ->find($id);
        return response()->json($structure);
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
