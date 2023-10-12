<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('access')->insert([
            'id' => 1,
            'name' => 'dashboard',
            'slug' => 'Dashboard',
        ]);
        DB::table('access')->insert([
            'id' => 2,
            'name' => 'keuangan',
            'slug' => 'Keuangan',
        ]);
        DB::table('access')->insert([
            'id' => 3,
            'name' => 'pembukuan',
            'slug' => 'Pembukuan',
        ]);
        DB::table('access')->insert([
            'id' => 4,
            'name' => 'akses',
            'slug' => 'Akses',
        ]);
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'owner',
            'description' => 'Membuka Semua Menu',
        ]);
        DB::table('roles_access')->insert([
            'roles_id' => 1,
            'access_id' => 1
        ]);
        DB::table('roles_access')->insert([
            'roles_id' => 1,
            'access_id' => 2
        ]);
        DB::table('roles_access')->insert([
            'roles_id' => 1,
            'access_id' => 3
        ]);
        DB::table('roles_access')->insert([
            'roles_id' => 1,
            'access_id' => 4
        ]);
        DB::table('users')->insert([
            'name' => "test",
            'email' => "test" . '@gmail.com',
            'roles_id' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
