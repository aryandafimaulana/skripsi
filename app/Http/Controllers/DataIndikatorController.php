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

        $totalProvinsi = DB::table('data_indikator_ketenagakerjaan')->count();

        $avgTPT = DB::table('data_indikator_ketenagakerjaan')->avg('tpt');
        $avgIPM = DB::table('data_indikator_ketenagakerjaan')->avg('ipm');
        $avgRLS = DB::table('data_indikator_ketenagakerjaan')->avg('rls');
        $avgTPAK = DB::table('data_indikator_ketenagakerjaan')->avg('tpak');
        $avgLowongan = DB::table('data_indikator_ketenagakerjaan')->avg('lowongan_kerja');

        $lowest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'asc')->first();
        $highest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'desc')->first();

        return view('data', compact(
            'data',
            'totalProvinsi',
            'avgTPT',
            'avgIPM',
            'avgRLS',
            'avgTPAK',
            'avgLowongan',
            'lowest',
            'highest'
        ));
    }

    public function kelola()
    {
        $data = DB::table('data_indikator_ketenagakerjaan')->get();

        $totalProvinsi = DB::table('data_indikator_ketenagakerjaan')->count();

        $avgTPT = DB::table('data_indikator_ketenagakerjaan')->avg('tpt');
        $avgIPM = DB::table('data_indikator_ketenagakerjaan')->avg('ipm');
        $avgRLS = DB::table('data_indikator_ketenagakerjaan')->avg('rls');
        $avgTPAK = DB::table('data_indikator_ketenagakerjaan')->avg('tpak');
        $avgLowongan = DB::table('data_indikator_ketenagakerjaan')->avg('lowongan_kerja');

        $lowest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'asc')->first();
        $highest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt', 'desc')->first();

        return view('kelolaData', compact(
            'data',
            'totalProvinsi',
            'avgTPT',
            'avgIPM',
            'avgRLS',
            'avgTPAK',
            'avgLowongan',
            'lowest',
            'highest'
        ));
    }

    public function store(Request $request)
    {
        DB::table('data_indikator_ketenagakerjaan')->insert([
            'provinsi' => $request->provinsi,
            'tpt' => $request->tpt,
            'ipm' => $request->ipm,
            'rls' => $request->rls,
            'tpak' => $request->tpak,
            'lowongan_kerja' => $request->lowongan_kerja,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'provinsi' => 'required|string|max:255',
            'tpt' => 'required|numeric',
            'ipm' => 'required|numeric',
            'rls' => 'required|numeric',
            'tpak' => 'required|numeric',
            'lowongan_kerja' => 'required|numeric',
        ]);

        // Gunakan model langsung (lebih aman dan Laravel-friendly)
        $data = DataIndikatorKetenagakerjaan::findOrFail($id);
        $data->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('data_indikator_ketenagakerjaan')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
