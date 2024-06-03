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
        Schema::create('jadwal_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->date('tanggal_result_vote');
            $table->date('tanggal_awal_vote');
            $table->date('tanggal_akhir_vote');
            $table->date('tanggal_orasi_vote');
            $table->time('jam_orasi_mulai');
            $table->time('jam_orasi_selesai');
            $table->string('tempat_orasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_votes');
    }
};
