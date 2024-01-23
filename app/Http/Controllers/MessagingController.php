<?php

namespace App\Http\Controllers;

use App\Models\AlerteMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessagingController extends Controller
{
    public function one($id) {
        $messages = AlerteMessage::query()->whereHas('alerteUser', function ($q) use ($id) {
            $q->where('user', $id);
        })->get();
        $user = $id;
        return view('admin.messaging.one', compact('messages', 'user'));
    }

    public function respondeMessage(Request $request) {
        $validator = Validator::make($request->all(), [
            'message_type' => 'required',
            'toUser' => 'required',
            'message' => 'required|string|max:255',
        ]);

        $message = AlerteMessage::query()->create([
            'user' => auth()->user()->id,
            'toUser' => $request->get('user'),
            'message_type' => $request->get('message_type'),
            'message' => $request->get('message'),
            'attachment' => $request->get('attachment'),
        ]);

        $message->save();


        return redirect()->back()->with('success', 'Envoyé avec succès');
    }
}
