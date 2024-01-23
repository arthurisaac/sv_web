<?php

namespace App\Http\Controllers;

use App\Models\Enrole;
use App\Models\PaymentOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlertePersonneAPrevenirController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uniq' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $enrole = Enrole::with("Personne_a_prevenir")->where("uniq", $request->get("uniq"))->get([
            'id',
            'nom',
            'prenom',
        ])->first();

        if ($enrole) {
            if ($enrole->Personne_a_prevenir) {
                foreach ($enrole->Personne_a_prevenir as $person) {

                    $data = array(
                        'nom' => $enrole->nom,
                        'prenom' => $enrole->prenom,
                        'telephone' => '72362736'
                    );

                    $url = 'https://sauvie.aino-digital.com/view/personne_a_prevenir_sms.php';
                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                    curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo 'Error: ' . curl_error($ch);
                    }
                    curl_close($ch);


                }
            } else {
                return response()->json(["message" => 'Aucune personne à prévenir trouvé.']);
            }
        } else {
            return response()->json(["message" => 'Aucun enroulé trouvé.']);
        }

        return response()->json(["message" => 'Tous les sms ont été envoyés.']);
    }

    public function listeDesProches(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uniq' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $enrole = Enrole::with("Personne_a_prevenir")->where("uniq", $request->get("uniq"))->get([
            'id',
            'nom',
            'prenom',
            'balance',
        ])->first();

        return response()->json(["message" => 'Enrole.', "enrole" => $enrole]);
    }

    public function alerterUnProche(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'uniq' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $enrole = Enrole::query()->where("uniq", $request->get("uniq"))->get([
            'id',
            'nom',
            'prenom',
            'balance',
        ])->first();

        if ($enrole) {

            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');
            $position = "https://maps.google.com/maps?z=12&t=m&q=$latitude,$longitude";


            $data = array(
                'nom' => $enrole->nom,
                'prenom' => $enrole->prenom,
                'position' => $position,
                'telephone' => $request->get("phone"),
            );

            $url = 'https://sauvie.aino-digital.com/view/prevenir_un_proche_sms.php';
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);

            return response()->json(["message" => 'SMS envoyé.' ]);

        }

        return response()->json(["message" => 'Enrolé non trouve.',]);

    }
}
