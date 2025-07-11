<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataIndikatorKetenagakerjaan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportExcel()
    {
        $data = DataIndikatorKetenagakerjaan::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([
            ['Provinsi', 'TPT', 'Lowongan Kerja', 'RLS', 'IPM', 'TPAK']
        ]);

        // Data rows
        foreach ($data as $index => $row) {
            $sheet->fromArray([
                $row->provinsi,
                $row->tpt,
                $row->lowongan_kerja,
                $row->rls,
                $row->ipm,
                $row->tpak
            ], null, 'A' . ($index + 2));
        }

        $writer = new Xlsx($spreadsheet);

        // Simpan sementara ke memori
        $filename = 'data_ketenagakerjaan.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
