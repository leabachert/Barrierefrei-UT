<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gebaeude;

class GebaeudeController extends Controller
{
    public function index()
    {
        return Gebaeude::select('id', 'name' )->get();
    }

    public function show($id)
    {
        $gebaeude = Gebaeude::with(['adressen', 'infosAussen', 'infosInnen', 'grundrisse'])->find($id);

        if (!$gebaeude) {
            return response()->json(['message' => 'Gebäude konnte nicht gefunden werden'], 404);
        }

        return response()->json($gebaeude);
    }

    public function gebaeudeInDerNahe(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $nahe = Gebaeude::findeGebaeudeInDerNahe(
            $request->input('latitude'),
            $request->input('longitude')
        );

        if ($nahe) {
            return response()->json($nahe);
        }
        return response()->json(null, 204);
    }
}


