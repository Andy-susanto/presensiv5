<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktu_presensi', function (Blueprint $table) {
            $table->char('id', 36);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->foreign('sesi_id')->references('id')->on('sesi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waktu_presensis');
    }
};
