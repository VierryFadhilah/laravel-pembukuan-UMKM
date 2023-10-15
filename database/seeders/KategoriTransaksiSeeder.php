<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $currentTimestamp = Carbon::now();

        // Data kategori transaksi untuk pemasukan
        $pemasukan = [
            ['jenis' => 'pemasukan', 'name' => 'Gaji', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Bonus', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Penjualan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Hadiah', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Investasi', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Warisan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Bunga Bank', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Refund', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Sewa', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pemasukan', 'name' => 'Lainnya', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        // Data kategori transaksi untuk pengeluaran
        $pengeluaran = [
            ['jenis' => 'pengeluaran', 'name' => 'Belanja Bulanan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Pembayaran Tagihan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Hiburan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Makanan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Transportasi', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Kesehatan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Pendidikan', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Pajak', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Donasi', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['jenis' => 'pengeluaran', 'name' => 'Lainnya', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        // Masukkan data ke dalam tabel kategori_transaksi
        DB::table('kategori_transaksi')->insert(array_merge($pemasukan, $pengeluaran));
    }
}
