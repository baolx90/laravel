<?php

namespace App\Http\Controllers;

use App\Models\Bot;
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
        $url = $request->get('url',[]);
        $urlData = [];
        foreach ($url as $item) {
            if(!is_null($item)){
                $urlData[] = $item;
            }
        }
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $prompt = $request->get('prompt',null);
        if(is_null($prompt)) {
            $prompt = "System: You are Figo, a customer support assistant. Anwser in very customer obsesion style
            Answer the question based on the context below
            If you don't know the answer, just say I don't know.
            Answer in the same language as the question.
            Context: {{context}}
            {% for item in chat_history %}
            human:
            {{item.inputs.question}}
            ai:
            {{item.outputs.answer}}
            {% endfor %}
            human:
            {{question}}";
        }

        $dataFile = [];
        $files = $request->file("file", []);
        foreach ($files as $file){
            $fileName = Str::random(10).'.'.Carbon::now()->timestamp.'.' . $file->getClientOriginalExtension();
            $file->storeAs(
                'vector-stores',
                $fileName,
                ['disk' => 'public']
            );
            $dataFile[] = asset('storage/vector-stores/'.$fileName);
        }
        $code = sha1(time());
        Bot::create([
            'name' => $request->get('name'),
            'prompt' => $prompt,
            'code' => sha1(time()),
            'data_source' => [
                'url' => $urlData,
                'file' => $dataFile,
            ],
            'status' => Bot::ACTIVE
        ]);

        Http::post(env('CHATBOT_URL').'/vector-data',[
            'name'=> $code,
            'prompt' => $prompt,
            'data_source' => [
                'url' => $urlData,
                'file' => $dataFile,
            ],
        ]);


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
