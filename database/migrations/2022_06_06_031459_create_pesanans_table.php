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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nomorpesanan');
            $table->string('nama');
            $table->string('telepon');
            $table->string('alamat');
            $table->string('kurir');
            $table->integer('harga');
            $table->integer('harga_total');
            $table->integer('ongkir');
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
        Schema::dropIfExists('pesanans');
    }
};
