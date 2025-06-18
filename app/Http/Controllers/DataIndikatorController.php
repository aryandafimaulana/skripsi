<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataIndikatorKetenagakerjaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DataIndikatorController extends Controller
{
    public function index()
    {
        $data = DataIndikatorKetenagakerjaan::all();
        return view('data', compact('data'));
    }

    public function dataCard()
    {
        $avgTPT = DB::table('data_indikator_ketenagakerjaan')->avg('tpt');
        $lowest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'asc')->first();
        $highest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'desc')->first();

        return view('homepage', compact('avgTPT', 'lowest', 'highest'));
    }

    public function dataTable()
    {
        $data = DB::table('data_indikator_ketenagakerjaan')->get();

        $avgTPT = DB::table('data_indikator_ketenagakerjaan')->avg('tpt');
        $avgIPM = DB::table('data_indikator_ketenagakerjaan')->avg('ipm');
        $avgRLS = DB::table('data_indikator_ketenagakerjaan')->avg('rls');
        $avgTPAK = DB::table('data_indikator_ketenagakerjaan')->avg('tpak');
        $avgLowongan = DB::table('data_indikator_ketenagakerjaan')->avg('lowongan_kerja');

        $lowest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'asc')->first();
        $highest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'desc')->first();

        return view('data', compact(
            'data',
            'avgTPT',
            'avgIPM',
            'avgRLS',
            'avgTPAK',
            'avgLowongan',
            'lowest',
            'highest'
        ));
    }

    public function exportCsv()
    {
        $data = DataIndikatorKetenagakerjaan::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_ketenagakerjaan.csv"',
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');

            // Header kolom
            fputcsv($handle, ['Provinsi', 'TPT', 'Lowongan Kerja', 'RLS', 'IPM', 'TPAK']);

            // Isi data
            foreach ($data as $item) {
                fputcsv($handle, [
                    $item->provinsi,
                    $item->tpt,
                    $item->lowongan_kerja,
                    $item->rls,
                    $item->ipm,
                    $item->tpak
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
