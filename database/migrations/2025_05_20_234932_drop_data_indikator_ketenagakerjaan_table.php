<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('data_indikator_ketenagakerjaan');
    }

    public function down(): void
    {
       
    }
};
