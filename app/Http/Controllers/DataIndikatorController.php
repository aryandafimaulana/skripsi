<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataIndikatorKetenagakerjaan;
use Illuminate\Support\Facades\DB;

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
}
