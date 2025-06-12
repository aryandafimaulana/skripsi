<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_indikator_ketenagakerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi');
            $table->float('rls');
            $table->float('tpt');
            $table->float('ump');
            $table->float('rasio_lapangan_pekerjaan');
            $table->string('cluster');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_indikator_ketenagakerjaan');
    }
};
