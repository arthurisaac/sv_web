<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all() {
        $users = User::query()->get();
        return view('admin.users.all', compact('users'));
    }
    public function partenaire() {
        $users = User::query()->whereNotNull('partenaire')->get();
        return view('admin.users.partenaires', compact('users'));
    }
    
    public function sauvie() {
        $users = User::query()->whereNotNull('uniq')->get();
        return view('admin.users.sauvie', compact('users'));
    }
 
    public function destroy($id) {
        $user = User::query()->find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->back()->with('success', 'Supprimé avec succès');
    }
}
