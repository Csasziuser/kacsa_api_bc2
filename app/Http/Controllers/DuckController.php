<?php

namespace App\Http\Controllers;

use App\Models\Duck;
use Illuminate\Http\Request;

class DuckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Duck $duck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Duck $duck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duck $duck)
    {
        //
    }
}
