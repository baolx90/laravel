<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
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
    public function show(string $code)
    {
        $bot = Bot::where(['code' => $code])->firstOrFail();
        $conversations = Cache::get('bot_'.$code, []);
        return view('pages.chatbot', compact('bot','conversations'));
    }
}
