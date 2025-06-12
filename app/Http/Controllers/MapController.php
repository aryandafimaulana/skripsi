<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
}
