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
        Schema::create('jadwal_orasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->date('tanggal_orasi_vote'); // tanggal orasi vote
            $table->time('jam_orasi_mulai'); // jam orasi mulai
            $table->string('tempat_orasi'); // tempat orasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_orasis');
    }
};
