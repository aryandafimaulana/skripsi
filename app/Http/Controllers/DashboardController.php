<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProvinsi = DB::table('data_indikator_ketenagakerjaan')->count();
        $avgTPT = DB::table('data_indikator_ketenagakerjaan')->avg('tpt');
        $highest = DB::table('data_indikator_ketenagakerjaan')->orderByDesc('tpt')->first();
        $lowest = DB::table('data_indikator_ketenagakerjaan')->orderBy('tpt')->first();

        return view('dashboard', compact('totalProvinsi', 'avgTPT', 'highest', 'lowest'));
    }
}