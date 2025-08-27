<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superRoleId = DB::table('roles')->where('name', 'super')->value('id');
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        DB::table('data_admin')->insert([
            'username' => 'super',
            'password' => Hash::make('super'),
            'role_id' => $superRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('data_admin')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => $adminRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
