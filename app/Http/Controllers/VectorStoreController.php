<?php

namespace App\Http\Controllers;

use App\Jobs\BotJob;
use App\Models\Bot;
use App\Models\BotUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class VectorStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bots = Bot::all();
        return view('pages.vector_store.index', compact('bots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.vector_store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = $request->get('url', []);
        $urlData = [];
        foreach ($url as $item) {
            if (!is_null($item)) {
                $urlData[] = $item;
            }
        }
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $prompt = $request->get('prompt', null);
        if (is_null($prompt)) {
            $prompt = "You are an AI assistant. You are helpful, professional, clever, and friendly. Do not answer any questions not related to the knowledge base.
Answer the question based on the context below, and if the question can't be answered based on the context, say \"I don't know\"";
        }

        $dataFile = [];
        $files = $request->file("file", []);
        foreach ($files as $file) {
            $fileName = Str::random(10) . '.' . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
            $file->storeAs(
                'vector-stores',
                $fileName,
                ['disk' => 'public']
            );
            $dataFile[] = asset('storage/vector-stores/' . $fileName);
        }
        $code = sha1(time());
        $bot = Bot::create([
            'name' => $request->get('name'),
            'prompt' => $prompt,
            'code' => $code,
            'data_source' => [
                'url' => $urlData,
                'file' => $dataFile,
            ],
            'status' => Bot::UNACTIVE
        ]);
        BotJob::dispatch($bot);


        return redirect()->route('index')
            ->with('success', 'Post created successfully.');
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
