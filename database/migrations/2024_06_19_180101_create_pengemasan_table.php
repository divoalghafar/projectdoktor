<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengemasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengemasan', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('keterangan');
            $table->string('ecommerce');
            $table->string('biaya');
            $table->integer('qty');
            $table->string('jumlah');
            $table->date('tanggal_pengemasan');
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
        Schema::dropIfExists('pengemasan');
    }
}
