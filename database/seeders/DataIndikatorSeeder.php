<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke file CSV yang sudah kamu upload ke Laravel (misalnya di storage/app/data)
        $csvPath = storage_path('app/data/hasil_final_regresi(2).csv');

        // Buka dan baca isi file
        if (!file_exists($csvPath)) {
            $this->command->error("File tidak ditemukan di: $csvPath");
            return;
        }

        $csv = array_map('str_getcsv', file($csvPath));
        $headers = array_map('trim', $csv[0]); // header
        unset($csv[0]); // hapus header

        foreach ($csv as $row) {
            $row = array_map('trim', $row);

            DB::table('data_indikator_ketenagakerjaan')->insert([
                'provinsi' => $row[0],
                'tpt' => (float) $row[1],
                'lowongan_kerja' => (int) $row[2],
                'rls' => (float) $row[3],
                'ipm' => (float) $row[4],
                'tpak' => (float) $row[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Data indikator berhasil diimport dari CSV.');
    }
}
