<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'super',
                'label' => 'Super Admin',
                'direct' => 'dashboard',
            ],
            [
                'name' => 'admin',
                'label' => 'Admin',
                'direct' => 'dashboard',
            ],
            [
                'name' => 'viewer',
                'label' => 'Viewer',
                'direct' => 'viewer.home',
            ],
        ]);
    }
}
