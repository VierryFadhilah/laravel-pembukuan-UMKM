<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RolesAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan default values untuk parameter
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default limit adalah 10, bisa disesuaikan
        $sort = $request->sort ?? 'updated_at'; // Menentukan dari tabel mana kolom 'updated_at' diambil
        $order = $request->order ?? 'desc';

        // Query untuk mengambil data pengguna dengan kolom-kolom yang diinginkan
        $roles = Roles::select('id', 'name', 'description', 'updated_at')
            ->where('name', '!=', 'owner') // Memastikan 'name' bukan 'owner'
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%') // Menentukan bahwa kolom 'name' diambil dari tabel 'users'
                    ->orWhere('description', 'like', '%' . $search . '%') // Menentukan bahwa kolom 'description' diambil dari tabel 'users'
                    ->orWhere('roles.name', 'like', '%' . $search . '%'); // Menentukan bahwa kolom 'description' diambil dari tabel 'users'

            });

        // Mengurutkan hasil jika sort dan order disediakan
        if ($sort && $order) {
            $roles->orderBy($sort, $order);
        }

        // Melakukan paginasi
        $roles = $roles->paginate($limit);

        // Menambahkan parameter ke hasil paginasi
        $roles->appends(['limit' => $limit, 'search' => $search, 'sort' => $sort, 'order' => $order]);

        // Mengembalikan response JSON
        $data = [
            'status' => 'success',
            'message' => 'Berhasil ambil data dengan paginasi',
            'data' => $roles
        ];

        return response()->json($data, 200);
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
        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Proses validasi data
            $data = $request->validate([
                'name' => 'required|string|unique:roles|max:255',
                'description' => 'required|string|max:255',
                'access' => 'array',
            ]);

            // Membuat role baru
            $roles = Roles::create($data);

            // Mendapatkan akses dari request
            $access = $request->input('access', []);

            // Menyimpan akses yang terkait dengan role
            foreach ($access as $value) {
                $rolesAccess = new RolesAccess();
                $rolesAccess->roles_id = $roles->id;
                $rolesAccess->access_id = $value;
                $rolesAccess->save();
            }

            // Commit transaksi jika sukses
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Roles berhasil disimpan',
                'data' => $roles
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan roles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(?string $id)
    {
        try {

            if ($id === "null") {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Role found',
                    'data' => [
                        'name' => "null",
                        'id' => null
                    ]
                ], 200);
            }
            // Cari peran berdasarkan ID
            $role = Roles::findOrFail($id);

            // Menggabungkan data akses terkait dengan peran
            $access = RolesAccess::where('roles_id', $role->id)->pluck('access_id') ?? null;

            // Mengembalikan data peran dan akses terkait dalam respons JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Role found',
                'data' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description,
                    'created_at' => $role->created_at,
                    'updated_at' => $role->updated_at,
                    'access' => $access
                ]
            ], 200);
        } catch (\Exception $e) {
            // Jika peran tidak ditemukan, tangkap pengecualian dan beri respons 404 Not Found
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }
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
        // Memulai transaksi database
        DB::beginTransaction();

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'description' => 'required|string|max:255',
                'access' => 'array',
            ]);

            $roles = Roles::find($id);

            if (!$roles) {
                return response()->json(['message' => 'Role not found'], 404);
            }

            $roles->name = $data['name'];
            $roles->description = $data['description'];
            $roles->save();

            // Menyinkronkan akses jika ada dalam request
            RolesAccess::where('roles_id', $id)->delete();

            // Mendapatkan akses dari request
            $access = $request->input('access', []);

            // Menyimpan akses yang terkait dengan role
            foreach ($access as $value) {
                $rolesAccess = new RolesAccess();
                $rolesAccess->roles_id = $roles->id;
                $rolesAccess->access_id = $value;
                $rolesAccess->save();
            }

            // Commit transaksi jika sukses
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Role updated successfully', 'data' => $roles], 200);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan roles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {


            $roles = Roles::findOrFail($id);
            $roles->delete();

            // Commit transaksi jika sukses
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Role delete successfully']);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus roles: ' . $e->getMessage()
            ], 500);
        }
    }
}
