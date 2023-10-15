<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $jenis = $request->jenis;
            $tanggal_transaksi = $request->tanggal_transaksi;

            $search = $request->input('search', '');
            $limit = $request->input('limit', 10); // Default limit adalah 10, bisa disesuaikan
            $sort = $request->sort ?? 'updated_at'; // Default sort adalah 'updated_at ?? bisa disesuaikan
            $order = $request->order ?? 'desc'; // Default order adalah 'desc', bisa disesuaikan

            // Validasi format tanggal_transaksi
            if (!strtotime($tanggal_transaksi)) {
                throw new \Exception('Format tanggal_transaksi tidak valid');
            }

            // Mengubah format tanggal_transaksi ke format yang sesuai
            $tanggal_transaksi = date('Y-m-d', strtotime($tanggal_transaksi));

            $transaksi = Transaksi::select('transaksi.id', 'transaksi.tanggal_transaksi', 'transaksi.description', 'transaksi.updated_at', 'transaksi.nominal')
                ->addSelect('kategori_transaksi.name as kategori_name')
                ->addSelect('users.name as user_name')
                ->leftJoin('kategori_transaksi', 'transaksi.kategori_id', '=', 'kategori_transaksi.id')
                ->leftJoin('users', 'transaksi.user_id', '=', 'users.id')
                ->whereDate('transaksi.tanggal_transaksi', '=', $tanggal_transaksi)
                ->where('transaksi.jenis', '=', $jenis)
                ->where(function ($query) use ($search) {
                    $query->where('transaksi.tanggal_transaksi', 'like', '%' . $search . '%')
                        ->orWhere('transaksi.description', 'like', '%' . $search . '%')
                        ->orWhere('kategori_transaksi.name', 'like', '%' . $search . '%');
                });

            // Mengurutkan hasil jika sort dan order disediakan
            if ($sort && $order) {
                $transaksi->orderBy($sort, $order);
            }

            // Melakukan paginasi
            $transaksi = $transaksi->paginate($limit);

            // Menambahkan parameter ke hasil paginasi
            $transaksi->appends(['limit' => $limit, 'search' => $search, 'sort' => $sort, 'order' => $order]);

            // Mengembalikan response JSON
            $data = [
                'status' => 'success',
                'message' => 'Berhasil ambil data dengan paginasi',
                'data' => $transaksi
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Tangkap kesalahan dan kirim respons error
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data Transaksi: ' . $e->getMessage()
            ], 500);
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


        try {
            $data = $request->validate([
                'user_id' => 'required|integer',
                'tanggal_transaksi' => 'required',
                'kategori_id' => 'required|integer',
                'description' => 'required|string',
                'nominal' => 'required|numeric'
            ]);
            // Ubah format tanggal transaksi menjadi format datetime
            $data['tanggal_transaksi'] = date('Y-m-d H:i:s', strtotime($data['tanggal_transaksi']));

            $transaksi = Transaksi::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan',
                'data' => $transaksi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            // Cari pengguna berdasarkan ID
            $Transaksi = Transaksi::findOrFail($id);

            // Hapus pengguna dari database
            $Transaksi->delete();

            // Mengembalikan respons sukses jika pengguna berhasil dihapus
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi  berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            // Jika pengguna tidak ditemukan atau terjadi kesalahan lain, tangkap pengecualian dan beri respons error
            return response()->json([
                'status' => 'error',
                'message' => 'gagal delete Transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
