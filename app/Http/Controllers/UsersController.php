<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        // Menggunakan default values untuk parameter
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default limit adalah 10, bisa disesuaikan
        $sort = $request->input('sort', 'users.name'); // Menentukan dari tabel mana kolom 'name' diambil
        $order = $request->input('order', 'asc');

        // Query untuk mengambil data pengguna dengan kolom-kolom yang diinginkan
        $users = User::select('users.id', 'users.name', 'users.email')
            ->addSelect('roles.name as roles_name')
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
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




    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = bcrypt($data['password']); // Enkripsi kata sandi

        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil disimpan',
            'data' => $user
        ], 201);
    }
}
