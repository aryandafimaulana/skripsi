<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataIndikatorKetenagakerjaan;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataUploadController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Hapus semua data lama
        DataIndikatorKetenagakerjaan::truncate();

        // Lewati baris header (baris pertama)
        foreach (array_slice($rows, 1) as $row) {
            DataIndikatorKetenagakerjaan::create([
                'provinsi'         => $row[0],
                'tpt'              => $row[1],
                'lowongan_kerja'   => $row[2],
                'rls'              => $row[3],
                'ipm'              => $row[4],
                'tpak'             => $row[5],
            ]);
        }

        return back()->with('success', 'Data berhasil diunggah dan digantikan!');
    }
}
