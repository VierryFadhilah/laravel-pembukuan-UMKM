<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        $sort = $request->sort ?? 'name'; // Gunakan 'name' sebagai nilai default untuk pengurutan
        $order = $request->order ?? 'asc'; // Gunakan 'asc' (ascending) sebagai nilai default untuk urutan

        $users = User::select('name', 'email', 'roles')
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('roles', 'like', '%' . $search . '%');

        if ($sort && $order) {
            $users->orderBy($sort, $order);
        }

        $users = $users->paginate($limit);

        $users->appends(['limit' => $limit, 'search' => $search, 'sort' => $sort, 'order' => $order]);

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
