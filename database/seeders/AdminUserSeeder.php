<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['username' => 'admin'],
            [
                'name'        => 'Administrator Gridas',
                'email'       => 'admin@gmail.com', // <--- Tambahkan baris ini
                'password'    => Hash::make('bankmini'),
                'role'        => 'admin',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }
}