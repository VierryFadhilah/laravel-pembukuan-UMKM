<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KategoriTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $jenis = $request->jenis;

            // Periksa apakah jenis adalah 'pemasukan' atau 'pengeluaran'
            if ($jenis !== 'pemasukan' && $jenis !== 'pengeluaran') {
                throw new \Exception('Jenis harus berupa "pemasukan" atau "pengeluaran"');
            }

            // Membangun kueri berdasarkan jenis
            $kategori_transaksi = KategoriTransaksi::where('jenis', $jenis)->get();

            // Mengembalikan data sebagai respons JSON
            return response()->json(['status' => 'success', 'message' => 'Data Kategori Transaksi', 'data' => $kategori_transaksi], 200);
        } catch (\Exception $e) {
            // Tangkap dan tanggapi pengecualian
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
