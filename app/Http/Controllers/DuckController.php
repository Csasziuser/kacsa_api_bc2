<?php

namespace App\Http\Controllers;

use App\Models\Duck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DuckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ducks = Duck::with('park')->get();
        return response()->json($ducks,options:JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:ducks,name', 
            'species' => 'required|string', 
            'band_number' => 'required|numeric|integer|unique:ducks:band_number', 
            'park_id' => 'sometimes|integer|exists:parks,id',
        ],[],
        [
            'name' => 'kacsa neve',
            'species' => 'fajta',
            'band_number' => 'gyűrűszám',
            'park_id' => 'parkazonosító'
        ]);
        try {
            Duck::create($validated);
            return response()->json(['uzenet' => 'A kacsa rögzítve'],201,options:JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response()->json(['uzenet' => 'Hiba lépett fel a kacsa rögzítése során!'],500,options:JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Display the specified resource.
     */
    public function relocate(string $id,Request $request)
    {
        $duck = Duck::find($id);

        if (!$duck) {
            return response()->json(['uzenet' => 'Nincs ilyen kacsa az adatbázisban!'],404,options:JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('park_id')) {
            return response()->json(['uzenet' => 'Hiányzó adat'],404,options:JSON_UNESCAPED_UNICODE); 
        }

        if ($request->park_id != null) {
            $request->validate(['park_id' => 'exists:parks,id'],[],['park_id' => 'park azonosító']);
        }

        $duck->park_id = $request->park_id;
        $duck->save();
        return response()->json(['uzenet' => 'Kacsa lokációja frissítve!'],options:JSON_UNESCAPED_UNICODE);
        
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function wandering()
    {
        $ducks = Duck::where('park_id', '=', null)->get();
        
        return response()->json($ducks,options:JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duck $duck)
    {
        //
    }
}
