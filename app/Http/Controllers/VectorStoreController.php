<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $request->validate([
            'name' => 'required|max:255',
        ]);
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
        $a = Bot::create([
            'name' => $request->get('name'),
            'data_source' => [
                'url' => $request->get('url'),
                'file' => $dataFile,
            ],
            'status' => Bot::UNACTIVE
        ]);
        return redirect()->route('pages.vector_store.index')
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
