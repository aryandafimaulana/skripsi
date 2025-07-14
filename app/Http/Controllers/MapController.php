<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\DataIndikatorKetenagakerjaan;

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

    public function hasil()
    {
        $data = DataIndikatorKetenagakerjaan::all();

        // Ambil X dan Y
        $X = [];
        $Y = [];

        foreach ($data as $item) {
            if (is_numeric($item->tpt) && is_numeric($item->ipm) && is_numeric($item->rls) && is_numeric($item->tpak) && is_numeric($item->lowongan_kerja)) {
                $X[] = [
                    'ipm' => $item->ipm,
                    'rls' => $item->rls,
                    'tpak' => $item->tpak,
                    'lowongan' => $item->lowongan_kerja,
                ];
                $Y[] = $item->tpt;
            }
        }

        // Hitung regresi linear berganda
        $n = count($X);
        if ($n === 0) {
            return view('hasilAnalisis', ['error' => 'Data tidak tersedia.']);
        }

        // Matriks X (dengan 1 sebagai konstanta)
        $X_matrix = [];
        foreach ($X as $row) {
            $X_matrix[] = [1, $row['ipm'], $row['rls'], $row['tpak'], $row['lowongan']];
        }

        // Hitung koefisien regresi: B = (X'X)^-1 X'Y
        $Xt = array_map(null, ...$X_matrix); // Transpose X
        $XtX = self::matMult($Xt, $X_matrix);
        $XtY = self::matMult($Xt, array_map(function($y){ return [$y]; }, $Y));
        $XtX_inv = self::inverseMatrix($XtX);

        if (!$XtX_inv) {
            return view('hasilAnalisis', ['error' => 'Gagal menghitung koefisien regresi.']);
        }

        $B = self::matMult($XtX_inv, $XtY);

        return view('hasilAnalisis', [
            'koefisien' => $B,
            'penjelasan' => [
                'IPM', 'RLS', 'TPAK', 'Lowongan Kerja'
            ]
        ]);
    }

    // Matrix multiplication
    private static function matMult($a, $b)
    {
        $result = [];
        for ($i = 0; $i < count($a); $i++) {
            for ($j = 0; $j < count($b[0]); $j++) {
                $sum = 0;
                for ($k = 0; $k < count($b); $k++) {
                    $sum += $a[$i][$k] * $b[$k][$j];
                }
                $result[$i][$j] = $sum;
            }
        }
        return $result;
    }

    // Matrix inverse (2D only, using Gauss-Jordan elimination)
    private static function inverseMatrix($matrix)
    {
        $n = count($matrix);
        $identity = array_map(function($i) use ($n) {
            return array_map(function($j) use ($i) {
                return $i === $j ? 1 : 0;
            }, range(0, $n - 1));
        }, range(0, $n - 1));

        for ($i = 0; $i < $n; $i++) {
            if ($matrix[$i][$i] == 0) return false;

            $pivot = $matrix[$i][$i];
            for ($j = 0; $j < $n; $j++) {
                $matrix[$i][$j] /= $pivot;
                $identity[$i][$j] /= $pivot;
            }

            for ($k = 0; $k < $n; $k++) {
                if ($k == $i) continue;
                $factor = $matrix[$k][$i];
                for ($j = 0; $j < $n; $j++) {
                    $matrix[$k][$j] -= $factor * $matrix[$i][$j];
                    $identity[$k][$j] -= $factor * $identity[$i][$j];
                }
            }
        }
        return $identity;
    }
}
