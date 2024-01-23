<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlerteResource;
use App\Models\Enrole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnroleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $enrole = Enrole::with("Personne_a_prevenir")
            ->with("Antecedants")
            ->where("uniq", $request->get("uniq"))->get([
                'id',
                'nom',
                'prenom',
                'date_naissance',
                'lieu_naissance',
                'sexe',
                'ville',
                'quartier',
                'telephone',
                'package',
                'avatar',
                'balance',
                'groupe_sanguin',
                'electrophorese',
                'maladie_particuliere',
                'created_at',
            ])->first();

        return response()->json(["message" => 'Information enrolé.', "enrole" => $enrole, "user" => Auth::user(),]);

    }

    public function findEnroleByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies sont invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $enroles = Enrole::with("Personne_a_prevenir")
            ->with("Antecedants")
            ->where('nom', 'like', '%' . request('name') . '%')
            ->orWhere('prenom', 'like', '%' . request('name') . '%')
            ->limit(5)
            ->get([
                'id',
                'nom',
                'prenom',
                'date_naissance',
                'lieu_naissance',
                'sexe',
                'ville',
                'quartier',
                'telephone',
                'package',
                'avatar',
                'balance',
                'groupe_sanguin',
                'electrophorese',
                'maladie_particuliere',
                'created_at',
            ]);

            return response()->json(["data" => $enroles]);
        //return new ApiResource($enroles);

    }

    public function findUserByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies sont invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $users = User::query()
            ->where('nom', 'like', '%' . request('name') . '%')
            ->orWhere('prenom', 'like', '%' . request('name') . '%')
            ->limit(5)
            ->get();

            return response()->json(["data" => $users]);
        //return new ApiResource($users);

    }

    public function saveKyc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doc' => 'required',
            'recto' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'verso' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::query()->find(auth()->user()->id);
        if ($user) {
            $recto = $request->file('recto') ? $request->file('recto')->store('kyc', 'public') : null;
            $verso = $request->file('verso') ? $request->file('verso')->store('kyc', 'public') : null;

            $user->verification_doc = $request->get("doc");
            $user->verification_doc_recto = $recto;
            $user->verification_doc_verso = $verso;
            $user->verified = -1;
            $user->save();
        }

        return response()->json([
            'message' => 'kyc update successfully.',
            'user' => $user,
        ], 201);
    }
}
