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
        Schema::create('kategori_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('jenis', ['pengeluaran', 'pemasukan']);
            $table->timestamps();
        });
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transaksi');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->decimal('nominal');
            $table->timestamps();

            // Menambahkan foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

            // Menambahkan foreign key untuk kategori_id
            $table->foreign('kategori_id')->references('id')->on('kategori_transaksi')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('kategori_transaksi');
    }
};
