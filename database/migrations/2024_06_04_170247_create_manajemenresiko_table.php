<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManajemenresikoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manajemenresiko', function (Blueprint $table) {
            $table->id();
            $table->date('Tanggal Retur')->nullable();
            $table->string('Nama Barang')->nullable();
            $table->integer('Jumlah')->nullable();
            $table->string('Penyebab')->nullable();
            $table->string('Status')->nullable();
            $table->string('Keterangan')->nullable();
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
        Schema::dropIfExists('manajemenresiko');
    }
}
