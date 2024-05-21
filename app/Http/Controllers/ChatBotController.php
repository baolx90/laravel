<?php

namespace App\Http\Controllers;

use App\Jobs\BotJob;
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
        $response = Http::post(env('CHATBOT_URL') . '/history', [
            'collection_name' => $bot->code
        ])->json();
        $conversations = $response['messages'] ?? [];
        return view('pages.chatbot', compact('bot','conversations'));
    }
    public function widget(string $code)
    {
        $bot = Bot::where(['code' => $code])->firstOrFail();
        $response = Http::post(env('CHATBOT_URL') . '/history', [
            'collection_name' => $bot->code
        ])->json();
        $conversations = $response['messages'] ?? [];
        return view('pages.widget', compact('bot','conversations'));
    }
}
