<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path = public_path('geo/38_Provinsi.json'); // pastikan file ada di sini
        $data = json_decode(file_get_contents($path), true);
        foreach ($data['features'] as $feature) {
            $nama = strtoupper($feature['properties']['PROVINSI'] ?? 'TANPA NAMA');
            $feature['properties']['PROVINSI'] = $nama;

            DB::table('provinsi')->insert([
                'id' => Str::uuid(),
                'provinsi' => $nama, // ⬅️ simpan ke kolom eksplisit
                'type' => $feature['type'],
                'geometry' => json_encode($feature['geometry']),
                'properties' => json_encode($feature['properties']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
