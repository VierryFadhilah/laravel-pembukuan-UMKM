<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        // Menggunakan default values untuk parameter
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default limit adalah 10, bisa disesuaikan
        $sort = $request->sort ?? 'users.updated_at'; // Menentukan dari tabel mana kolom 'name' diambil
        $order = $request->order ?? 'desc';

        // Query untuk mengambil data pengguna dengan kolom-kolom yang diinginkan
        $users = User::select('users.id', 'users.name', 'users.email', 'users.updated_at')
            ->addSelect('roles.name as roles_name')
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->where('users.id', '!=', 1)
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%') // Menentukan bahwa kolom 'name' diambil dari tabel 'users'
                    ->orWhere('users.email', 'like', '%' . $search . '%') // Menentukan bahwa kolom 'email' diambil dari tabel 'users'
                    ->orWhere('roles.name', 'like', '%' . $search . '%'); // Menentukan bahwa kolom 'email' diambil dari tabel 'users'
            });

        // Mengurutkan hasil jika sort dan order disediakan
        if ($sort && $order) {
            $users->orderBy($sort, $order);
        }

        // Melakukan paginasi
        $users = $users->paginate($limit);

        // Menambahkan parameter ke hasil paginasi
        $users->appends(['limit' => $limit, 'search' => $search, 'sort' => $sort, 'order' => $order]);

        // Mengembalikan response JSON
        $data = [
            'status' => 'success',
            'message' => 'Berhasil ambil data dengan paginasi',
            'data' => $users
        ];

        return response()->json($data, 200);
    }

    public function show(string $id)
    {
        try {
            // Cari pengguna berdasarkan ID
            $user = User::findOrFail($id);

            // Mengembalikan data pengguna dalam respons JSON
            return response()->json([
                'status' => 'success',
                'message' => 'User found',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            // Jika pengguna tidak ditemukan, tangkap pengecualian dan beri respons 404 Not Found
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }


    public function store(Request $request)
    {

        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:6',
                'roles_id' => 'nullable|exists:roles,id',
            ]);

            $data['password'] = bcrypt($data['password']); // Enkripsi kata sandi

            $user = User::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Pengguna berhasil disimpan',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'gagal membuat user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            // Cari pengguna berdasarkan ID
            $user = User::findOrFail($id);

            // Validasi data dari permintaan
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'roles_id' => 'nullable|exists:roles,id',
            ]);

            // Perbarui data pengguna dengan data baru
            $user->name = $request->name;
            $user->email = $request->email;
            $user->roles_id = $request->roles_id;
            // Tambahkan perbarui atribut lain sesuai kebutuhan

            // Simpan perubahan ke database
            $user->save();

            // Mengembalikan respons sukses jika berhasil memperbarui data pengguna
            return response()->json([
                'status' => 'success',
                'message' => 'User Berhasil di update',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            // Jika pengguna tidak ditemukan, validasi gagal, atau ada kesalahan lain, tangkap pengecualian dan beri respons error
            return response()->json([
                'status' => 'error',
                'message' => 'gagal update user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            // Cari pengguna berdasarkan ID
            $user = User::findOrFail($id);

            // Hapus pengguna dari database
            $user->delete();

            // Mengembalikan respons sukses jika pengguna berhasil dihapus
            return response()->json([
                'status' => 'success',
                'message' => 'User User berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            // Jika pengguna tidak ditemukan atau terjadi kesalahan lain, tangkap pengecualian dan beri respons error
            return response()->json([
                'status' => 'error',
                'message' => 'gagal delete user: ' . $e->getMessage()
            ], 500);
        }
    }
}
