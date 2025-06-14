<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    public function index()
    {
        $provinsi = DB::table('data_indikator_ketenagakerjaan')
            ->select('provinsi')
            ->distinct()
            ->get();

        return view('maps', compact('provinsi'));
    }

    public function getGeoJson()
    {
        // Ambil data indikator per provinsi, pakai keyBy agar mudah dicari
        $indikator = DB::table('data_indikator_ketenagakerjaan')
            ->select('provinsi', 'tpt', 'ipm', 'rls', 'lowongan_kerja', 'tpak')
            ->get()
            ->keyBy(fn($row) => strtoupper(trim($row->provinsi)));

        // Ambil fitur provinsi dari tabel `provinsi`
        $features = DB::table('provinsi')->get();

        // Buat FeatureCollection GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->map(function ($item) use ($indikator) {
                $provName = strtoupper($item->provinsi);
                $indikatorData = $indikator->get($provName);

                // Decode properties dari DB lalu gabungkan dengan data indikator
                $properties = json_decode($item->properties, true);
                $properties['PROVINSI'] = $provName;

                if ($indikatorData) {
                    $properties['TPT'] = $indikatorData->tpt;
                    $properties['IPM'] = $indikatorData->ipm;
                    $properties['RLS'] = $indikatorData->rls;
                    $properties['LOWONGAN_KERJA_TERDAFTAR'] = $indikatorData->lowongan_kerja;
                    $properties['TPAK'] = $indikatorData->tpak;
                }

                return [
                    'type' => $item->type,
                    'geometry' => json_decode($item->geometry),
                    'properties' => $properties
                ];
            })->values()
        ];

        return response()->json($geojson);
    }
}
