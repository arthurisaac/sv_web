<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KYCController extends Controller
{
    public function nonVerified()  {
        $users = User::query()->where('verified', 0)
        ->whereNotNull('verification_doc_recto')
        ->whereNotNull('verification_doc_verso')
        ->get();
        return view('admin.kyc.non-verifie', compact('users'));
    }
    
    public function verified()  {
        $users = User::query()->where('verified', 1)->get();
        return view('admin.kyc.verifie', compact('users'));
    }
    
    public function enCours()  {
        $users = User::query()->where('verified', -1)->get();
        return view('admin.kyc.en-cours', compact('users'));
    }
    
    public function accept($id)  {

        $user = User::query()->find($id);
        if ($user) {
            $user->verified = 1;
            $user->save();
        }
        return redirect()->back()->with('success', 'Enregistré avec succès');
    }
    
    public function refuse($id)  {

        $user = User::query()->find($id);
        if ($user) {
            $user->verified = 0;
            $user->save();
        }
        return redirect()->back()->with('success', 'Enregistré avec succès');
    }
}
