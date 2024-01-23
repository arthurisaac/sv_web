<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlerteResource;
use App\Http\Resources\ApiResource;
use App\Models\AlerteDiscussion;
use App\Models\AlerteMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class AlerteMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            'discussion' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }


        $messages = AlerteMessage::query()
            ->where('discussion', $request->get('discussion'))
            ->get();

         return response()->json(["data" => $messages]);
        //return new ApiResource($messages);
    }

    /**
     * Display a listing of discussion from popup
     */
    public function discussionFromPopup(Request $request)
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

        $discussion = AlerteDiscussion::query()
            ->where('alerte_user_regular', auth()->user()->id)
            ->where('subject', $request->get('alerte'))
            ->first();
        if (!$discussion) {
            $discussion = new AlerteDiscussion([
                'alerte_user_regular' => auth()->user()->id,
                'subject' => $request->get("alerte"),
            ]);
            $discussion->save();
        }

        $messages = AlerteMessage::query()
            ->where("discussion", $discussion->id)
            ->get();

        return response()->json([
            'message' => 'Discussion sur l alerte ' . $request->get('alerte'). '',
            'messages' => $messages,
            'discussion' => $discussion,
        ], 201);
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
            'discussion' => 'required',
            //'message_type' => 'required',
            'message' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Les données fournies étaient invalides.' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $path = "";
        $message_type = "1";

        if ($request->file('file')) {
            $path = $request->file('file')->store('msg', 'public');
            $message_type = "2";
        }


        $message = AlerteMessage::query()->create([
            'user' => auth()->user()->id,
            'message_type' => $message_type,
            'message' => $request->get('message'),
            'attachment' => $path,
            'discussion' => $request->get('discussion'),
        ]);

        $message->save();

        return response()->json(["message" => 'Nouveau message.', "message" => new AlerteResource($message)], 201);
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
