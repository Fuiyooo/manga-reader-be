<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Manga;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Biasanya untuk menampilkan data

        $dataManga = Manga::all();
        return $dataManga;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $number)
    {
        $mangaArray = collect(range(1, $number))->map(function () {
            $name = Str::random(8);
            $description = Str::random(20);
            $category = Str::random(5);

            $manga = Manga::create([
                'name' => $name,
                'category' => $category,
                'desc' => $description,
            ]);

            $titles[] = $manga->name;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'data manga successfully inserted',
            'nubmer' => $number,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $description = $request->desc;
        $category = $request->category;

        $manga = Manga::where('name', $name)->first();

        if($manga){
            return response()->json([
                'status' => 'failed',
                'message' => 'data exist, cannot insert'
            ]);
        }

        $manga = Manga::create([
            'name' => $name,
            'category' => $category,
            'desc' => $description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'manga successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manga = Manga::find($id);

        if(!$manga){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Manga not found'
            ]);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully show manga',
            'data' => $manga
        ]);
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
        $deleteManga = Manga::where('id', $id) -> delete();

        return response() -> json([
            'status' => 'success',
            'message' => 'data is deleted',
            'data_id' => $id,
        ]);
    }
}
