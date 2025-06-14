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

    public function getTPT()
    {
        $data = DB::table('data_indikator_ketenagakerjaan')
            ->select('provinsi', 'tpt')
            ->get();

        return response()->json($data);
    }

    public function getGeoJson()
    {
        $features = DB::table('provinsi')->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->map(fn($row) => [
                'type' => $row->type,
                'geometry' => json_decode($row->geometry),
                'properties' => array_merge(json_decode($row->properties, true), [
                    'PROVINSI' => $row->provinsi
                ])
            ])
        ];

        return response()->json($geojson);
    }
}
