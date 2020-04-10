<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenyewaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_penyewaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl');
            $table->integer('id_anggota');
            $table->integer('id_petugas');
            $table->integer('id_mobil');
            $table->string('jumlah');
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
        Schema::dropIfExists('table_penyewaan');
    }
}
