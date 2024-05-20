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

class CrawlUrlJob implements ShouldQueue
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
        BotJob::dispatch($this->bot->code, $this->bot->prompt,$dataSource['file']);
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
//        BotJob::dispatch($this->bot->code, $this->bot->prompt,$dataSource['url']);
    }
    function curl()
    {
        Http::post(env('CHATBOT_URL').'/vector-data',[
            'name'=> $this->code,
            'prompt' => $this->prompt,
            'url' => $this->urlData,
            'file' => $this->dataFile,
        ]);
    }
}
