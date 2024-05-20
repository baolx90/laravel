<?php

namespace App\Jobs;

use App\Models\Bot;
use App\Models\BotUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class BotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bot;

    /**
     * Create a new job instance.
     */
    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BotUrl::where(['bot_id' => $this->bot->id])->delete();
        $dataSource = $this->bot->data_source;
        $this->curl([] , $dataSource['file']);
        $dataSourceUrl = [];
        foreach ($dataSource['url'] as $url) {
            $response = Http::post(env('CHATBOT_URL') . '/crawl-url', [
                'url' => $url,
            ])->json();
            foreach ($response as $item) {
                $dataSourceUrl[] = [
                    'bot_id' => $this->bot->id,
                    'url' => $item
                ];;
            }
        }
        BotUrl::insert($dataSourceUrl);
        foreach ($dataSourceUrl as $item){
            $this->curl([$item['url']]);
        }
        Bot::where('id', $this->bot->id)
            ->update([
                'status' => Bot::ACTIVE
            ]);
    }

    function curl($url = [], $file = [])
    {
        Http::post(env('CHATBOT_URL') . '/vector-data', [
            'name' => $this->bot->code,
            'prompt' => $this->bot->prompt,
            'url' => $url,
            'file' => $file,
        ]);
    }
}
