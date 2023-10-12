<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menyisipkan data ke tabel 'access'
        DB::table('access')->insert([
            'name' => 'dashboard',
            'slug' => 'Dashboard',
        ]);
        DB::table('access')->insert([
            'name' => 'keuangan',
            'slug' => 'Keuangan',
        ]);
        DB::table('access')->insert([
            'name' => 'pembukuan',
            'slug' => 'Pembukuan',
        ]);
        DB::table('access')->insert([
            'name' => 'akses',
            'slug' => 'Akses',
        ]);

        // Menyisipkan data ke tabel 'roles'
        DB::table('roles')->insert([
            'name' => 'owner',
            'description' => 'Membuka Semua Menu',
        ]);

        // Menyisipkan data ke tabel 'roles_access'
        $accessIds = [1, 2, 3, 4]; // ID akses dari tabel 'access' yang ingin dihubungkan dengan peran 'owner'
        $roleId = 1; // ID peran 'owner'

        foreach ($accessIds as $accessId) {
            DB::table('roles_access')->insert([
                'roles_id' => $roleId,
                'access_id' => $accessId,
            ]);
        }

        // Menyisipkan data ke tabel 'users'
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'roles_id' => $roleId,
            'password' => Hash::make('password'),
        ]);
    }
}
