<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use PhpOption\Option;

class ParkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parks = Park::withCount('ducks')->get();
        return response()->json($parks,options:JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:parks,name',
            'district' => 'required|string',
            'pond_count' => 'required|numeric|integer|max:255',
        ],[],
        [
            'name' => 'park név',
            'district' => 'kerület',
            'pond_count' => 'tavak száma'
        ]);
        try {
            Park::create($validated);

            return response()->json(['uzenet' => 'A park rögzítve'],201,options:JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return response()->json(['uzenet' => 'Hiba lépett fel a park rögzítése során!'],500,options:JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $park)
    {
        $park = Park::find($park);

        if (!$park) {
            return response()->json(['uzenet' => 'Nincs ilyen park az adatbázisban!'],404,options:JSON_UNESCAPED_UNICODE);
        }

        return response()->json($park->ducks(),options:JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Park $park)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Park $park)
    {
        //
    }
}
