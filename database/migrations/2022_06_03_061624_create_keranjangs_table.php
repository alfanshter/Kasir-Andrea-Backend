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
        //status
        //0 = belum terbeli 
        //1 = terjual

        // proses
        // 0 = dalam proses
        // 1 = selesai
        // 2 = cancel
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk');
            $table->foreign('id_produk')->references('id')->on('produks')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('harga');
            $table->bigInteger('harga_modal');
            $table->integer('jumlah');
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nomorpesanan')->nullable();
            $table->integer('is_status')->default(0);
            $table->integer('is_proses')->default(1);

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
        Schema::dropIfExists('keranjangs');
    }
};
