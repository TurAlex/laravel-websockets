<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent(auth()->user(), $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function sendTestMessage(Request $request)
    {
//        dd($request->all());
        $user = User::all()->first();
        $message = $user->messages()->create([
            'message' => $request->get('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
