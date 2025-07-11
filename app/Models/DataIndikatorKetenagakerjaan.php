<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIndikatorKetenagakerjaan extends Model
{
    use HasFactory;

    protected $table = 'data_indikator_ketenagakerjaan';

    protected $fillable = [
        'provinsi',
        'tpt',
        'lowongan_kerja',
        'rls',
        'ipm',
        'tpak',
    ];
}
