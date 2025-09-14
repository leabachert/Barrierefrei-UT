<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gebaeude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GebaeudeAdminController extends Controller
{
    public function index()
    {
        return Gebaeude::select('id','name')->get();
    }

    public function show($id)
    {
        $gebaeude = Gebaeude::with(['adressen','infosAussen','infosInnen','grundrisse'])->find($id);
        if (!$gebaeude) {
            return response()->json(['message' => 'Gebäude konnte nicht gefunden werden'], 404);
        }
        return response()->json($gebaeude);
    }
    public function update(Request $request, $id)
    {
        $gebaeude = Gebaeude::with(['adressen', 'infosAussen', 'infosInnen', 'grundrisse'])->find($id);
        if (!$gebaeude) {
            return response()->json(['message' => 'Gebäude konnte nicht gefunden werden'], 404);
        }

        $data = $request->validate([
            'name'    => ['required','string'],
            'infos'   => ['required', 'boolean'],
            'bereich' => ['sometimes','nullable','string'],

            'adressen'                  => ['sometimes','array'],
            'adressen.adresse'          => ['sometimes','nullable','string',],
            'adressen.latitude'         => ['sometimes','nullable','numeric','between:-90,90'],
            'adressen.longitude'        => ['sometimes','nullable','numeric','between:-180,180'],

            'infos_aussen'                      => ['sometimes','array'],
            'infos_aussen.barrierefrei'         => ['sometimes','nullable','boolean'],
            'infos_aussen.eingang'              => ['sometimes','nullable','string'],
            'infos_aussen.tueroeffner'          => ['sometimes','nullable','boolean'],
            'infos_aussen.haltestelle'          => ['sometimes','nullable','string'],
            'infos_aussen.parkplatz'            => ['sometimes','nullable','boolean'],
            'infos_aussen.parkplatz_ort'        => ['sometimes','nullable','string'],
            'infos_aussen.wegbeschaffenheit'    => ['sometimes','nullable','string'],
            'infos_aussen.blindenleitsystem'    => ['sometimes','nullable','boolean'],
            'infos_aussen.infosaeule'           => ['sometimes','nullable','boolean'],
            'infos_aussen.infosaeule_ort'       => ['sometimes','nullable','string'],

            'infos_innen'                       => ['sometimes','array'],
            'infos_innen.aufzug'                => ['sometimes','nullable','string'],
            'infos_innen.toilette'              => ['sometimes','nullable','string'],
            'infos_innen.infosaeule'            => ['sometimes','nullable','boolean'],
            'infos_innen.infosaeule_ort'        => ['sometimes','nullable','string'],
            'infos_innen.blindenleitsystem'     => ['sometimes','nullable','boolean'],
            'infos_innen.raumzugang'            => ['sometimes','nullable','string'],
            'infos_innen.sitzplaetze'           => ['sometimes','nullable','boolean'],
            'infos_innen.induktionsschleife'    => ['sometimes','nullable','boolean'],
            'infos_innen.induktionsschleife_raum'=> ['sometimes','nullable','string'],
            'infos_innen.ruheraum'              => ['sometimes','nullable','string'],
            'infos_innen.sanitaetsraum'         => ['sometimes','nullable','boolean'],
            'infos_innen.sanitaetsraum_raum'    => ['sometimes','nullable','string'],

            'grundrisse'               => ['sometimes','array'],
            'grundrisse.grundriss'     => ['sometimes','nullable','string'],
        ]);

        DB::beginTransaction();

        try {
            $gebaeude->fill($data);
            if (array_key_exists('infos', $data)) {
                $gebaeude->infos = (int)!!$data['infos'];
            }
            $gebaeude->save();

            if (array_key_exists('adressen', $data)) {
                if ($gebaeude->adressen) {
                    $gebaeude->adressen->update($data['adressen']);
                } else {
                    $gebaeude->adressen()->create($data['adressen']);
                }
            }

            if (array_key_exists('infos_aussen', $data)) {
                $a = $data['infos_aussen'];
                foreach (['tueroeffner','parkplatz','blindenleitsystem','infosaeule'] as $key) {
                    if (array_key_exists($key, $a)) $a[$key] = (bool)$a[$key];
                }

                if ($gebaeude->infosAussen) {
                    $gebaeude->infosAussen->update($a);
                } else {
                    $gebaeude->infosAussen()->create($a);
                }
            }

            if (array_key_exists('infos_innen', $data)) {
                $i = $data['infos_innen'];
                foreach (['infosaeule','blindenleitsystem','sitzplaetze','induktionsschleife','sanitaetsraum'] as $key) {
                    if (array_key_exists($key, $i)) $i[$key] = (bool)$i[$key];
                }

                if ($gebaeude->infosInnen) {
                    $gebaeude->infosInnen->update($i);
                } else {
                    $gebaeude->infosInnen()->create($i);
                }
            }

            if (array_key_exists('grundrisse', $data)) {
                if ($gebaeude->grundrisse) {
                    $gebaeude->grundrisse->update($data['grundrisse']);
                } else {
                    $gebaeude->grundrisse()->create($data['grundrisse']);
                }
            }

            DB::commit();

            $gebaeude->load(['adressen','infosAussen','infosInnen','grundrisse']);

            return response()->json([
                'message'  => 'Gebäudedetails erfolgreich aktualisiert',
                'gebaeude' => $gebaeude
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Aktualisieren der Gebäudedetails fehlgeschlagen',
            ], 422);
        }
    }
}
