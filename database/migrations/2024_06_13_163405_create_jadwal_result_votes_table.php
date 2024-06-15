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
        Schema::create('jadwal_result_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->date('tanggal_result_vote'); //hasil
            $table->time('jam_result_vote'); // jam orasi mulai
            $table->string('tempat_result_vote'); // tempat result
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_result_votes');
    }
};
