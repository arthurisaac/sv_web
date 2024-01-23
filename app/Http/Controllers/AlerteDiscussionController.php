<?php

namespace App\Http\Controllers;

use App\Models\AlerteDiscussion;
use App\Models\AlerteMessage;
use Illuminate\Http\Request;

class AlerteDiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discussions = AlerteDiscussion::with("AlerteUserRegular")->get();
        return view('admin.chats.index', compact("discussions"));
    }


    public function getMessages($id)
    {
        $messages = AlerteMessage::query()
            ->where('discussion', $id)
            ->get();

        return response()->json(["messages" => $messages]);
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
        $request->validate([
            'discussion' => 'required',
        ]);

        $message = AlerteMessage::query()->create([
            'user' => auth()->user()->id,
            'message_type' => $request->get('message_type'),
            'message' => $request->get('message'),
            'attachment' => $request->get('attachment'),
            'discussion' => $request->get('discussion'),
        ]);

        $message->save();

        $messages = AlerteMessage::with('alerteUser')
            ->where('discussion', $request->get("discussion"))
            ->get();

        return back()->with(compact("messages"));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $messages = AlerteMessage::with("alerteUser")
            ->where("discussion", $id)
            ->get();

        return view("admin.chats.show", compact("messages", "id"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlerteDiscussion $alerteDiscussion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlerteDiscussion $alerteDiscussion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlerteDiscussion $alerteDiscussion)
    {
        //
    }
}
