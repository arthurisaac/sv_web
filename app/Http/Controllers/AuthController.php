<?php

namespace App\Http\Controllers;

use App\Models\Enrole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('telephone', 'password');

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;

            return response()->json(['token' => $token, 'user' => auth()->user()]);
        }

        return response()->json(['error' => 'Unauthorized', 'message' => 'Email ou mot de passe incorrecte'], 401);
    }

    public function loginWithQr(Request $request) {
        $code = $request->get('qrcode');

        // On vérifie que l'enrole existe
        $enrole = Enrole::query()->where("uniq", $code)->first();

        if ($enrole) {

            // On vérifie si un utilisateur sauvie alerte exsite
            $user = User::query()->where('uniq', $code)->first();

            if ($user == null) {
                $user = User::create([
                    'nom' => $enrole->nom,
                    'prenom' => $enrole->prenom,
                    'telephone' => $enrole->telephone,
                    'password' => Hash::make(env('DEFAULT_PASSWORD', 'SAUVIEALERTEDEFAULTKEY')),
                    'uniq' => $enrole->uniq
                ]);
                $user->save();
            }

            $token = $user->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['error' => 'Unauthorized', 'message' => 'Code QR incorrecte'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;

        return response()->json([
            'message' => 'Compte crée avec succès.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function loginWithGoogle(Request $request)
    {
        $credentials = $request->only('email');

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;

            return response()->json(['token' => $token, 'user' => auth()->user()]);
        }

        $user = User::create([
            'nom' => $request->nom,
            'name' => $request->nom,
            //'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make("SAUVIEALERTETOKENKEY"),
        ]);



        $token = $user->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;

        return response()->json([
            'message' => 'Compte crée avec succès.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::query()
            ->find(auth()->user()->id)
            ->update(['password' => Hash::make($request->get('password'))]);

        if ($user) {
            //$token = \auth()->user()->createToken('SAUVIEALERTETOKENKEY')->plainTextToken;
            return response()->json([
                'message' => 'Mot de passe modifié avec succès.',
                'user' => $user,
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized', 'message' => 'Non authorisé'], 401);

    }

    public function change_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'telephone' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::query()
            ->find(auth()->user()->id)
            ->update([
                'nom' => $request->get('nom'),
                'prenom' => $request->get('prenom'),
                'telephone' => $request->get('telephone'),
            ]);

        if ($user) {
            return response()->json([
                'message' => 'Informations personnelles modifiés avec succès.',
                'user' => \auth()->user(),
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized', 'message' => 'Non authorisé'], 401);

    }

    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
