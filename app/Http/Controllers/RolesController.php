<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

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
        $sort = $request->input('sort', 'name'); // Menentukan dari tabel mana kolom 'name' diambil
        $order = $request->input('order', 'asc');

        // Query untuk mengambil data pengguna dengan kolom-kolom yang diinginkan
        $roles = Roles::select('id', 'name', 'description')
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
        $data = $request->validate([
            'name' => 'required|string|unique:roles|max:255',
            'description' => 'required|string|max:255',
            'access' => 'array',
        ]);

        $access = $request->access;

        foreach ($access as $key => $value) {
        }

        $roles = Roles::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Roles berhasil disimpan',
            'data' => $roles
        ], 201);
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
