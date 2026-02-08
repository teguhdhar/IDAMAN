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
      Schema::create('pengeluarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('program_id')
            ->constrained('programs')
            ->onDelete('restrict');

        $table->bigInteger('jumlah_pengeluaran');
        $table->text('keterangan')->nullable();
        $table->date('tanggal_pengeluaran');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
