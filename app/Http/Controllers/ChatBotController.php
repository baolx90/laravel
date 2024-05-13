<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Support\Facades\Cache;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bot = Bot::findOrFail($id);
        $conversations = Cache::get('bot_'.$id, []);
        return view('pages.chatbot', compact('bot','conversations'));
    }
}
